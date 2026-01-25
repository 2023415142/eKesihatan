@extends('layouts.app')
 
@section('content')
<h2>Upload Medical Document</h2>
<p>Patient: {{ $appointment->patient->name }}</p>
 
<form method="POST" action="{{ route('doctor.documents.store', $appointment) }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="document_type">Document Type</label>
        <input id="document_type" name="document_type" type="text" placeholder="Medical certificate or referral letter">
    </div>
    <div>
        <label for="document">Select File (JPG, PNG, PDF)</label>
        <input id="document" name="document" type="file" required>
    </div>
    <button type="submit">Upload</button>
</form>
@endsection
