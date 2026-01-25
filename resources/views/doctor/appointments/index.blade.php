@extends('layouts.app')

@section('content')
<h2>Daily Appointments</h2>

<form method="GET" action="{{ route('doctor.appointments.index') }}">
    <label for="date">Select Date</label>
    <input id="date" name="date" type="date" value="{{ $date }}">
    <button type="submit">View</button>
</form>

<table>
    <thead>
        <tr>
            <th>Time</th>
            <th>Patient</th>
            <th>Service</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->scheduled_at->format('h:i A') }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->service?->name ?? 'General' }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
                <td>
                    <a href="{{ route('doctor.appointments.show', $appointment) }}">View</a>
                    <a href="{{ route('doctor.patients.history', $appointment->patient) }}">History</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No appointments found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection