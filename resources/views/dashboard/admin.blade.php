@extends('layouts.app')
 
@section('content')
<h2>Admin Dashboard</h2>
<p>Manage services, doctors, appointment slots, and approvals.</p>
 
<div><strong>Pending Appointments:</strong> {{ $pendingAppointments }}</div>
<div><strong>Today's Appointments:</strong> {{ $todayAppointments }}</div>
<div><strong>Active Services:</strong> {{ $servicesCount }}</div>
<div><strong>Doctors:</strong> {{ $doctorsCount }}</div>
 
<h3>Quick Actions</h3>
<ul>
    <li><a href="{{ route('admin.services.index') }}">Manage Health Services</a></li>
    <li><a href="{{ route('admin.doctors.index') }}">Manage Doctors</a></li>
    <li><a href="{{ route('admin.slots.index') }}">Manage Appointment Slots</a></li>
    <li><a href="{{ route('admin.appointments.index') }}">Manage Appointments</a></li>
</ul>
@endsection
