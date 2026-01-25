@extends('layouts.app')
 
@section('content')
<h2>QR Check-In</h2>
<p>Show this QR code at Unit Kesihatan UiTM Perlis to get your queue number.</p>
<p><strong>Appointment:</strong> {{ $appointment->scheduled_at->format('d M Y, h:i A') }}</p>
 
<div>
    <img src="{{ $qrImageUrl }}" alt="QR code for check-in">
</div>
<p>Alternatively, open this URL on the counter device:</p>
<p><a href="{{ $checkInUrl }}">{{ $checkInUrl }}</a></p>
@endsection
