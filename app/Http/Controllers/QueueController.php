<?php
 
namespace App\Http\Controllers;
 
use App\Models\Appointment;
use App\Models\QueueTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class QueueController extends Controller
{
    public function qr(Request $request, Appointment $appointment)
    {
        if ($appointment->patient_id !== $request->user()->id) {
            abort(403);
        }
 
        $checkInUrl = route('queue.check-in', $appointment->check_in_token);
        $qrImageUrl = 'https://chart.googleapis.com/chart?chs=220x220&cht=qr&chl=' . urlencode($checkInUrl);
 
        return view('appointments.qr', [
            'appointment' => $appointment,
            'qrImageUrl' => $qrImageUrl,
            'checkInUrl' => $checkInUrl,
        ]);
    }
 
    public function checkIn(string $token)
    {
        $appointment = Appointment::where('check_in_token', $token)->firstOrFail();
 
        if ($appointment->checked_in_at || $appointment->queueTicket) {
            return view('queue.checked-in', [
                'appointment' => $appointment,
                'ticket' => $appointment->queueTicket,
            ]);
        }
 
        $ticket = DB::transaction(function () use ($appointment) {
            $today = now()->toDateString();
            $nextNumber = (int) QueueTicket::where('issued_on', $today)->max('number') + 1;
 
            $ticket = QueueTicket::create([
                'appointment_id' => $appointment->id,
                'issued_on' => $today,
                'number' => $nextNumber,
            ]);
 
            $appointment->update([
                'queue_number' => $nextNumber,
                'checked_in_at' => now(),
            ]);
 
            return $ticket;
        });
 
        return view('queue.checked-in', [
            'appointment' => $appointment->fresh(),
            'ticket' => $ticket,
        ]);
    }
}
