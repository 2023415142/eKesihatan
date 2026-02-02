<?php
 
namespace App\Http\Controllers;
 
use App\Models\Appointment;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
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
 
        $payload = $this->buildQrPayload($checkInUrl);

        return response($payload['data'])
            ->header('Content-Type', $payload['mime']);
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
        $payload = $this->buildQrPayload($checkInUrl);

        return 'data:' . $payload['mime'] . ';base64,' . base64_encode($payload['data']);
    }

    private function buildQrPayload(string $checkInUrl): array
    {
        if (method_exists(Builder::class, 'create')) {
            $result = Builder::create()
                ->writer(new SvgWriter())
                ->data($checkInUrl)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->size(220)
                ->margin(2)
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->build();

            return [
                'data' => $result->getString(),
                'mime' => $result->getMimeType(),
            ];
        }

        $qrCodeClass = '\\Endroid\\QrCode\\QrCode';
        if (class_exists($qrCodeClass)) {
            $qrCode = new $qrCodeClass($checkInUrl);

            if (method_exists($qrCode, 'setEncoding')) {
                $qrCode->setEncoding(new Encoding('UTF-8'));
            } elseif (method_exists($qrCode, 'withEncoding')) {
                $qrCode = $qrCode->withEncoding(new Encoding('UTF-8'));
            }

            if (method_exists($qrCode, 'setErrorCorrectionLevel')) {
                $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());
            } elseif (method_exists($qrCode, 'withErrorCorrectionLevel')) {
                $qrCode = $qrCode->withErrorCorrectionLevel(new ErrorCorrectionLevelLow());
            }

            if (method_exists($qrCode, 'setSize')) {
                $qrCode->setSize(220);
            } elseif (method_exists($qrCode, 'withSize')) {
                $qrCode = $qrCode->withSize(220);
            }

            if (method_exists($qrCode, 'setMargin')) {
                $qrCode->setMargin(2);
            } elseif (method_exists($qrCode, 'withMargin')) {
                $qrCode = $qrCode->withMargin(2);
            }

            $writer = class_exists(SvgWriter::class) ? new SvgWriter() : new PngWriter();

            if (method_exists($writer, 'write')) {
                $result = $writer->write($qrCode);

                return [
                    'data' => $result->getString(),
                    'mime' => $result->getMimeType(),
                ];
            }

            if (method_exists($writer, 'writeString')) {
                $data = $writer->writeString($qrCode);
                $mime = method_exists($writer, 'getContentType') ? $writer->getContentType() : 'image/png';

                return [
                    'data' => $data,
                    'mime' => $mime,
                ];
            }
        }

        return [
            'data' => '',
            'mime' => 'image/png',
        ];
    }
}