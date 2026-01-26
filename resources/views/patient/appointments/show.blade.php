@extends('layouts.app')
 
@section('content')
<h2 data-i18n="Appointment Details">Appointment Details</h2>
 
<p><strong data-i18n="Date:">Date:</strong> {{ $appointment->scheduled_at->format('d M Y') }}</p>
<p><strong data-i18n="Time:">Time:</strong> {{ $appointment->scheduled_at->format('h:i A') }}</p>
<p><strong data-i18n="Doctor:">Doctor:</strong> {{ $appointment->doctor->name }}</p>
<p><strong data-i18n="Service:">Service:</strong> {{ $appointment->service?->name ?? 'General' }}</p>
<p><strong data-i18n="Status:">Status:</strong> {{ ucfirst($appointment->status) }}</p>
<p><strong data-i18n="Notes:">Notes:</strong> {{ $appointment->notes ?? 'N/A' }}</p>
 
@if ($appointment->queue_number)
    <p><strong data-i18n="Queue Number:">Queue Number:</strong> {{ $appointment->queue_number }}</p>
@else
    <p data-i18n="Queue number will be assigned when your booking is confirmed.">Queue number will be assigned when your booking is confirmed.</p>
@endif
 
@if ($appointment->checked_in_at)
    <p data-i18n="Attendance recorded.">Attendance recorded.</p>
@else
    <a href="{{ route('patient.appointments.qr', $appointment) }}" data-i18n="Show QR Check-In">Show QR Check-In</a>
@endif
 
<section>
    <h3 data-i18n="SMS Notifications">SMS Notifications</h3>
    <p data-i18n="You will receive SMS confirmation and reminders 1 day and 1 hour before your appointment.">
        You will receive SMS confirmation and reminders 1 day and 1 hour before your appointment.
    </p>
</section>
 
<h3 data-i18n="Medical Documents">Medical Documents</h3>
<ul>
    @forelse ($appointment->documents as $document)
        <li>
            {{ $document->filename }}
            <a href="{{ route('patient.documents.show', $document) }}" target="_blank" data-i18n="View Document">View Document</a>
        </li>
    @empty
        <li data-i18n="No documents uploaded yet.">No documents uploaded yet.</li>
    @endforelse
</ul>
@endsection