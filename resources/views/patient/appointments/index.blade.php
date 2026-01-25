@extends('layouts.app')
 
@section('content')
<h2>My Appointments</h2>
 
<a href="{{ route('patient.appointments.create') }}">Book New Appointment</a>
 
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor</th>
            <th>Service</th>
            <th>Status</th>
            <th>Actions</th>
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
                <td>
                    <a href="{{ route('patient.appointments.show', $appointment) }}">View</a>
                    <a href="{{ route('patient.appointments.edit', $appointment) }}">Reschedule</a>
                    <form action="{{ route('patient.appointments.destroy', $appointment) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Cancel</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No appointments found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
