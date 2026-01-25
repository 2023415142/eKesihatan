@extends('layouts.app')

@section('content')
<h2>Check-In Successful</h2>

<p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
<p><strong>Appointment:</strong> {{ $appointment->scheduled_at->format('d M Y, h:i A') }}</p>

@if ($appointment->queue_number)
    <p><strong>Your Queue Number:</strong> {{ $appointment->queue_number }}</p>
@endif

@if ($appointment->checked_in_at)
    <p><strong>Checked in at:</strong> {{ $appointment->checked_in_at->format('h:i A') }}</p>
@endif
@endsection