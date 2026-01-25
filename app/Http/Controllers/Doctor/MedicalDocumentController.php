<?php
 
namespace App\Http\Controllers\Doctor;
 
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalDocument;
use Illuminate\Http\Request;
 
class MedicalDocumentController extends Controller
{
    public function create(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->id()) {
            abort(403);
        }
 
        return view('doctor.documents.create', [
            'appointment' => $appointment->load('patient'),
        ]);
    }
 
    public function store(Request $request, Appointment $appointment)
    {
        if ($appointment->doctor_id !== $request->user()->id) {
            abort(403);
        }
 
        $data = $request->validate([
            'document' => ['required', 'file', 'max:5120', 'mimes:pdf'],
            'document_type' => ['nullable', 'string', 'max:255'],
        ]);
 
        $file = $data['document'];
 
        $appointment->documents()->create([
            'uploaded_by' => $request->user()->id,
            'document_type' => $data['document_type'] ?? null,
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'document_data' => file_get_contents($file->getRealPath()),
            'uploaded_at' => now(),
        ]);
 
        return redirect()->route('doctor.appointments.show', $appointment)
            ->with('status', 'Medical document uploaded.');
    }
 
    public function show(MedicalDocument $document)
    {
        $document->load('appointment');
        $user = auth()->user();
 
        if (!$user || (!$user->isDoctor() && $document->appointment->patient_id !== $user->id)) {
            abort(403);
        }
 
        return response($document->document_data)
            ->header('Content-Type', $document->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $document->filename . '"');
    }
}