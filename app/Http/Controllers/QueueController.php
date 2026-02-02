<?php
 
namespace App\Http\Controllers;
 
use App\Models\Appointment;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
 
class QueueController extends Controller
{
    public function qr(Request $request, Appointment $appointment)
    {
        if ($appointment->patient_id !== $request->user()->id) {
            abort(403);
        }
 
        $checkInUrl = route('queue.check-in', $appointment->check_in_token);
        $qrImageUrl = route('patient.appointments.qr-image', $appointment, false);
        $qrImageData = $this->buildQrDataUri($checkInUrl);
 
        return view('appointments.qr', [
            'appointment' => $appointment,
            'qrImageUrl' => $qrImageUrl,
            'qrImageData' => $qrImageData,
            'checkInUrl' => $checkInUrl,
        ]);
    }
 
    public function qrImage(Request $request, Appointment $appointment)
    {
        if ($appointment->patient_id !== $request->user()->id) {
            abort(403);
        }
 
        $checkInUrl = route('queue.check-in', $appointment->check_in_token);
 
        $result = Builder::create()
            ->writer(new SvgWriter())
            ->data($checkInUrl)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->size(220)
            ->margin(2)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->build();
 
        return response($result->getString())
            ->header('Content-Type', $result->getMimeType());
    }
 
    public function checkIn(string $token)
    {
        $appointment = Appointment::where('check_in_token', $token)->firstOrFail();
 
        if ($appointment->checked_in_at) {
            return view('queue.checked-in', [
                'appointment' => $appointment,
            ]);
        }
 
        $appointment->update([
            'checked_in_at' => now(),
            'status' => 'checked-in',
        ]);
 
        return view('queue.checked-in', [
            'appointment' => $appointment->fresh(),
        ]);
    }

    private function buildQrDataUri(string $checkInUrl): string
    {
        $result = Builder::create()
            ->writer(new SvgWriter())
            ->data($checkInUrl)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->size(220)
            ->margin(2)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->build();

        return 'data:' . $result->getMimeType() . ';base64,' . base64_encode($result->getString());
    }
}