@extends('layouts.app')

@section('content')
<h2>Appointments</h2>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Service</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->scheduled_at->format('d M Y') }}</td>
                <td>{{ $appointment->scheduled_at->format('h:i A') }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->service?->name ?? 'General' }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
                <td><a href="{{ route('admin.appointments.show', $appointment) }}">Review</a></td>
            </tr>
        @empty
            <tr><td colspan="7">No appointments found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection