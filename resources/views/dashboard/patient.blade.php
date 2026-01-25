@extends('layouts.app')
 
@section('content')
<h2>Patient Dashboard</h2>
<p>Manage your appointments and health services.</p>
 
<ul>
    <li><a href="{{ route('patient.services.index') }}">View Health Services</a></li>
    <li><a href="{{ route('patient.appointments.create') }}">Book Appointment</a></li>
    <li><a href="{{ route('patient.appointments.index') }}">My Appointments</a></li>
    <li><a href="{{ route('patient.bmi.show') }}">BMI Calculator</a></li>
</ul>
 
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
 
@include('partials.translator')
@endsection
