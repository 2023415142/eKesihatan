<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
 
class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments.index', [
            'appointments' => Appointment::with(['patient', 'doctor', 'service', 'slot'])
                ->orderByDesc('scheduled_at')
                ->get(),
        ]);
    }
 
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', [
            'appointment' => $appointment->load(['patient', 'doctor', 'service', 'slot', 'documents']),
            'doctors' => User::where('role', User::ROLE_DOCTOR)->orderBy('name')->get(),
            'slots' => AppointmentSlot::with('doctor')->orderBy('slot_date')->orderBy('start_time')->get(),
        ]);
    }
 
    public function update(Request $request, Appointment $appointment, SmsService $smsService)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,rescheduled,cancelled'],
            'doctor_id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_DOCTOR)],
            'appointment_slot_id' => ['required', 'exists:appointment_slots,id'],
            'notes' => ['nullable', 'string'],
        ]);
 
        $slot = AppointmentSlot::findOrFail($data['appointment_slot_id']);
 
        if ($slot->doctor_id !== (int) $data['doctor_id']) {
            return back()->withErrors(['appointment_slot_id' => 'Selected slot does not match the chosen doctor.']);
        }
 
        $scheduledAt = $slot->slot_date->format('Y-m-d') . ' ' . $slot->start_time;
 
        $appointment->update([
            'status' => $data['status'],
            'doctor_id' => $data['doctor_id'],
            'appointment_slot_id' => $slot->id,
            'scheduled_at' => $scheduledAt,
            'notes' => $data['notes'] ?? $appointment->notes,
            'approved_at' => $data['status'] === 'approved' ? now() : $appointment->approved_at,
            'cancelled_at' => in_array($data['status'], ['rejected', 'cancelled'], true) ? now() : $appointment->cancelled_at,
        ]);
 
        if (in_array($data['status'], ['approved', 'rescheduled'], true)) {
            $appointment->load(['patient', 'doctor']);
            $smsService->sendAppointmentUpdate(
                $appointment->patient,
                $appointment,
                $data['status']
            );
        }
 
        return redirect()->route('admin.appointments.show', $appointment)->with('status', 'Appointment updated.');
    }
}
