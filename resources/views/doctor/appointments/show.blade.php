@extends('layouts.app')
 
@section('content')
<h2 data-i18n="Appointment Details">Appointment Details</h2>
 
<p><strong data-i18n="Patient:">Patient:</strong> {{ $appointment->patient->name }}</p>
<p><strong data-i18n="Service:">Service:</strong> {{ $appointment->service?->name ?? 'General' }}</p>
<p><strong data-i18n="Scheduled At:">Scheduled At:</strong> {{ $appointment->scheduled_at->format('d M Y, h:i A') }}</p>
<p><strong data-i18n="Status:">Status:</strong> {{ ucfirst($appointment->status) }}</p>
@if ($appointment->checked_in_at)
    <p><strong data-i18n="Checked in at:">Checked in at:</strong> {{ $appointment->checked_in_at->format('h:i A') }}</p>
@else
    <p data-i18n="Not checked in yet.">Not checked in yet.</p>
@endif
 
<form method="POST" action="{{ route('doctor.appointments.update', $appointment) }}">
    @csrf
    @method('PATCH')
    <label for="status" data-i18n="Update Status">Update Status</label>
    <select id="status" name="status">
        <option value="completed" @selected($appointment->status === 'completed')>Completed</option>
        <option value="no-show" @selected($appointment->status === 'no-show')>No-show</option>
    </select>
    <button type="submit" data-i18n="Update">Update</button>
</form>
 
<h3 data-i18n="Medical Documents">Medical Documents</h3>
<a href="{{ route('doctor.documents.create', $appointment) }}" data-i18n="Upload Document">Upload Document</a>
<ul>
    @forelse ($appointment->documents as $document)
        <li>
            {{ $document->filename }}
            <a href="{{ route('doctor.documents.show', $document) }}" target="_blank" data-i18n="View Document">View Document</a>
        </li>
    @empty
        <li data-i18n="No documents uploaded.">No documents uploaded.</li>
    @endforelse
</ul>
@endsection