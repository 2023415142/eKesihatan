<?php
 
namespace App\Http\Controllers\Patient;
 
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\HealthService;
use App\Models\QueueTicket;
use App\Models\User;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
 
class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        return view('patient.appointments.index', [
            'appointments' => Appointment::with(['doctor', 'service', 'slot'])
                ->where('patient_id', $request->user()->id)
                ->orderByDesc('scheduled_at')
                ->get(),
        ]);
    }
 
    public function create()
    {
        return view('patient.appointments.create', [
            'services' => HealthService::where('is_active', true)->orderBy('name')->get(),
            'doctors' => User::where('role', User::ROLE_DOCTOR)->orderBy('name')->get(),
            'slots' => AppointmentSlot::with('doctor')
                ->where('is_active', true)
                ->whereDate('slot_date', '>=', now()->toDateString())
                ->orderBy('slot_date')
                ->orderBy('start_time')
                ->get(),
        ]);
    }
 
    public function store(Request $request, SmsService $smsService)
    {
        $data = $request->validate([
            'health_service_id' => ['required', Rule::exists('health_services', 'id')->where('is_active', true)],
            'doctor_id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_DOCTOR)],
            'appointment_slot_id' => ['required', 'exists:appointment_slots,id'],
            'notes' => ['nullable', 'string'],
        ]);
 
        $slot = AppointmentSlot::where('id', $data['appointment_slot_id'])
            ->where('doctor_id', $data['doctor_id'])
            ->firstOrFail();
 
        $scheduledAt = Carbon::parse(
            $slot->slot_date->format('Y-m-d') . ' ' . $slot->start_time
        );
 
        if (!$slot->is_active || $scheduledAt->isPast()) {
            return back()->withErrors(['appointment_slot_id' => 'This slot is no longer available.'])->withInput();
        }
 
        $activeCount = Appointment::where('appointment_slot_id', $slot->id)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->count();
 
        if ($activeCount >= $slot->capacity) {
            return back()->withErrors(['appointment_slot_id' => 'This slot is fully booked.'])->withInput();
        }
 
        $scheduledAt = $scheduledAt->format('Y-m-d H:i:s');
 
        $appointment = DB::transaction(function () use ($request, $data, $slot, $scheduledAt) {
            $appointment = Appointment::create([
                'patient_id' => $request->user()->id,
                'doctor_id' => $data['doctor_id'],
                'health_service_id' => $data['health_service_id'],
                'appointment_slot_id' => $slot->id,
                'scheduled_at' => $scheduledAt,
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
                'check_in_token' => (string) Str::uuid(),
            ]);
 
            $issuedOn = $slot->slot_date->format('Y-m-d');
            $nextNumber = (int) QueueTicket::where('issued_on', $issuedOn)->max('number') + 1;
 
            QueueTicket::create([
                'appointment_id' => $appointment->id,
                'issued_on' => $issuedOn,
                'number' => $nextNumber,
            ]);
 
            $appointment->update(['queue_number' => $nextNumber]);
 
            return $appointment;
        });
 
        $smsService->sendAppointmentConfirmation($appointment->patient, $appointment);
 
        return redirect()->route('patient.appointments.show', $appointment)
            ->with('status', 'Appointment booked successfully. Confirmation SMS sent.');
    }
 
    public function show(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($request, $appointment);
 
        return view('patient.appointments.show', [
            'appointment' => $appointment->load(['doctor', 'service', 'slot', 'documents']),
        ]);
    }
 
    public function edit(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($request, $appointment);
 
        return view('patient.appointments.edit', [
            'appointment' => $appointment,
            'slots' => AppointmentSlot::with('doctor')
                ->where('is_active', true)
                ->whereDate('slot_date', '>=', now()->toDateString())
                ->orderBy('slot_date')
                ->orderBy('start_time')
                ->get(),
        ]);
    }
 
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($request, $appointment);
 
        $data = $request->validate([
            'appointment_slot_id' => ['required', 'exists:appointment_slots,id'],
        ]);
 
        $slot = AppointmentSlot::findOrFail($data['appointment_slot_id']);
 
        $scheduledAt = Carbon::parse(
            $slot->slot_date->format('Y-m-d') . ' ' . $slot->start_time
        );
 
        if (!$slot->is_active || $scheduledAt->isPast()) {
            return back()->withErrors(['appointment_slot_id' => 'This slot is no longer available.'])->withInput();
        }
 
        $activeCount = Appointment::where('appointment_slot_id', $slot->id)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->where('id', '!=', $appointment->id)
            ->count();
 
        if ($activeCount >= $slot->capacity) {
            return back()->withErrors(['appointment_slot_id' => 'This slot is fully booked.'])->withInput();
        }
 
        $scheduledAt = $scheduledAt->format('Y-m-d H:i:s');
 
        DB::transaction(function () use ($appointment, $slot, $scheduledAt) {
            $appointment->update([
                'appointment_slot_id' => $slot->id,
                'doctor_id' => $slot->doctor_id,
                'scheduled_at' => $scheduledAt,
                'status' => 'pending',
            ]);
 
            $issuedOn = $slot->slot_date->format('Y-m-d');
            $nextNumber = (int) QueueTicket::where('issued_on', $issuedOn)->max('number') + 1;
 
            $ticket = $appointment->queueTicket;
            if ($ticket) {
                $ticket->update([
                    'issued_on' => $issuedOn,
                    'number' => $nextNumber,
                ]);
            } else {
                QueueTicket::create([
                    'appointment_id' => $appointment->id,
                    'issued_on' => $issuedOn,
                    'number' => $nextNumber,
                ]);
            }
 
            $appointment->update(['queue_number' => $nextNumber]);
        });
 
        return redirect()->route('patient.appointments.show', $appointment)
            ->with('status', 'Appointment rescheduled. Awaiting approval.');
    }
 
    public function destroy(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($request, $appointment);
 
        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
 
        return redirect()->route('patient.appointments.index')->with('status', 'Appointment cancelled.');
    }
 
    private function authorizeAppointment(Request $request, Appointment $appointment): void
    {
        if ($appointment->patient_id !== $request->user()->id) {
            abort(403);
        }
    }
}