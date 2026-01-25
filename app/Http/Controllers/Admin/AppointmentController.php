<?php
 
namespace App\Http\Controllers\Doctor;
 
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
 
class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', now()->toDateString());
 
        $appointments = Appointment::with(['patient', 'service', 'slot'])
            ->where('doctor_id', $request->user()->id)
            ->whereDate('scheduled_at', $date)
            ->orderBy('scheduled_at')
            ->get();
 
        return view('doctor.appointments.index', [
            'appointments' => $appointments,
            'date' => $date,
        ]);
    }
 
    public function show(Request $request, Appointment $appointment)
    {
        $this->authorizeDoctor($request, $appointment);
 
        return view('doctor.appointments.show', [
            'appointment' => $appointment->load(['patient', 'service', 'slot', 'documents']),
        ]);
    }
 
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeDoctor($request, $appointment);
 
        $data = $request->validate([
            'status' => ['required', 'in:completed,no-show'],
        ]);
 
        $appointment->update([
            'status' => $data['status'],
        ]);
 
        return redirect()->route('doctor.appointments.show', $appointment)->with('status', 'Appointment updated.');
    }
 
    private function authorizeDoctor(Request $request, Appointment $appointment): void
    {
        if ($appointment->doctor_id !== $request->user()->id) {
            abort(403);
        }
    }
}