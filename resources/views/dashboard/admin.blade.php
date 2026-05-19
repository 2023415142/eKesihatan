@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2 data-i18n="Admin Dashboard">Admin Dashboard</h2>
        <p data-i18n="Manage services, doctors, appointment slots, and approvals.">Manage services, doctors, appointment slots, and approvals.</p>
    </div>
    <span class="status-chip" data-i18n="Today">Today</span>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <span data-i18n="Pending Appointments:">Pending Appointments:</span>
        <strong>{{ $pendingAppointments }}</strong>
    </div>
    <div class="stat-card">
        <span data-i18n="Today's Appointments:">Today's Appointments:</span>
        <strong>{{ $todayAppointments }}</strong>
    </div>
    <div class="stat-card">
        <span data-i18n="Active Services:">Active Services:</span>
        <strong>{{ $servicesCount }}</strong>
    </div>
    <div class="stat-card">
        <span data-i18n="Doctors:">Doctors:</span>
        <strong>{{ $doctorsCount }}</strong>
    </div>
</div>

<section>
    <h3 data-i18n="Quick Actions">Quick Actions</h3>
    <div class="quick-actions">
        <a class="button-link" href="{{ route('admin.services.index') }}" data-i18n="Manage Health Services">Manage Health Services</a>
        <a class="button-link" href="{{ route('admin.doctors.index') }}" data-i18n="Manage Doctors">Manage Doctors</a>
        <a class="button-link" href="{{ route('admin.slots.index') }}" data-i18n="Manage Appointment Slots">Manage Appointment Slots</a>
        <a class="button-link" href="{{ route('admin.appointments.index') }}" data-i18n="Manage Appointments">Manage Appointments</a>
        <a class="button-link secondary" href="{{ route('staff.patients.index') }}" data-i18n="Patient Directory">Patient Directory</a>
    </div>
</section>
@endsection