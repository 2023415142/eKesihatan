@extends('layouts.app')
 
@section('content')
<h2>Check-In Successful</h2>
 
<p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
<p><strong>Appointment:</strong> {{ $appointment->scheduled_at->format('d M Y, h:i A') }}</p>
 
@if ($ticket)
    <p><strong>Your Queue Number:</strong> {{ $ticket->number }}</p>
@endif
 
@if ($appointment->checked_in_at)
    <p>Checked in at: {{ $appointment->checked_in_at->format('h:i A') }}</p>
@endif
@endsection
