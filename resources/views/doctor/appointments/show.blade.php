@extends('layouts.app')

@section('content')
<h2>Appointment Details</h2>

<p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
<p><strong>Service:</strong> {{ $appointment->service?->name ?? 'General' }}</p>
<p><strong>Scheduled At:</strong> {{ $appointment->scheduled_at->format('d M Y, h:i A') }}</p>
<p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>

@if ($appointment->checked_in_at)
    <p><strong>Checked in at:</strong> {{ $appointment->checked_in_at->format('h:i A') }}</p>
@else
    <p>Not checked in yet.</p>
@endif

<form method="POST" action="{{ route('doctor.appointments.update', $appointment) }}">
    @csrf
    @method('PATCH')
    <label for="status">Update Status</label>
    <select id="status" name="status">
        <option value="completed" @selected($appointment->status === 'completed')>Completed</option>
        <option value="no-show" @selected($appointment->status === 'no-show')>No-show</option>
    </select>
    <button type="submit">Update</button>
</form>

<h3>Medical Documents</h3>
<a href="{{ route('doctor.documents.create', $appointment) }}">Upload PDF Document</a>
<ul>
    @forelse ($appointment->documents as $document)
        <li>
            {{ $document->filename }}
            <a href="{{ route('doctor.documents.show', $document) }}" target="_blank">View PDF</a>
        </li>
    @empty
        <li>No documents uploaded.</li>
    @endforelse
</ul>
@endsection