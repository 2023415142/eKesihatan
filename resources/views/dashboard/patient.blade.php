@extends('layouts.app')
 
@section('content')
<h2>Patient Dashboard</h2> 
<h3>Upcoming Appointments</h3>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor</th>
            <th>Service</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->scheduled_at->format('d M Y') }}</td>
                <td>{{ $appointment->scheduled_at->format('h:i A') }}</td>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->service?->name ?? 'General' }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No upcoming appointments.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection