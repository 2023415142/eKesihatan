@extends('layouts.app')
 
@section('content')
<h2>Doctor Dashboard</h2>
<p>Today's appointments for {{ now()->format('d M Y') }}</p>
 
<a href="{{ route('doctor.appointments.index') }}">View Daily Appointments</a>
 
<table>
    <thead>
        <tr>
            <th>Time</th>
            <th>Patient</th>
            <th>Service</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->scheduled_at->format('h:i A') }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->service?->name ?? 'General' }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
            </tr>
        @empty
            <tr><td colspan="4">No appointments scheduled.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
