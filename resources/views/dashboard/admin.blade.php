@extends('layouts.app')

@section('content')
<h2>Admin Dashboard</h2>
<p>Manage services, doctors, appointment slots, and approvals from the left navigation panel.</p>

<section>
    <div><strong>Pending Appointments:</strong> {{ $pendingAppointments }}</div>
    <div><strong>Today's Appointments:</strong> {{ $todayAppointments }}</div>
    <div><strong>Active Services:</strong> {{ $servicesCount }}</div>
    <div><strong>Doctors:</strong> {{ $doctorsCount }}</div>
</section>
@endsection