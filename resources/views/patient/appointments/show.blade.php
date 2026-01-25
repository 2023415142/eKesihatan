@extends('layouts.app')
 
@section('content')
<h2>Appointment Details</h2>
 
<p><strong>Date:</strong> {{ $appointment->scheduled_at->format('d M Y') }}</p>
<p><strong>Time:</strong> {{ $appointment->scheduled_at->format('h:i A') }}</p>
<p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
<p><strong>Service:</strong> {{ $appointment->service?->name ?? 'General' }}</p>
<p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
<p><strong>Notes:</strong> {{ $appointment->notes ?? 'N/A' }}</p>
 
@if ($appointment->queue_number)
    <p><strong>Queue Number:</strong> {{ $appointment->queue_number }}</p>
@endif
 
<a href="{{ route('patient.appointments.qr', $appointment) }}">Show QR Check-In</a>
 
<h3>Medical Documents</h3>
<ul>
    @forelse ($appointment->documents as $document)
        <li>
            {{ $document->filename }}
            <a href="{{ route('patient.documents.show', $document) }}" target="_blank">View</a>
        </li>
    @empty
        <li>No documents uploaded yet.</li>
    @endforelse
</ul>
@endsection
