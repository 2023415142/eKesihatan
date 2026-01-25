@extends('layouts.app')

@section('content')
<h2>QR Check-In</h2>
<p>Show this QR code at the clinic to record your attendance.</p>
@if ($appointment->queue_number)
    <p><strong>Your Queue Number:</strong> {{ $appointment->queue_number }}</p>
@endif
<p><strong>Appointment:</strong> {{ $appointment->scheduled_at->format('d M Y, h:i A') }}</p>

<div>
    <img src="{{ $qrImageUrl }}" alt="QR code for check-in" width="220" height="220">
</div>

<p>Alternatively, open this URL on the counter device:</p>
<p><a href="{{ $checkInUrl }}">{{ $checkInUrl }}</a></p>
@endsection