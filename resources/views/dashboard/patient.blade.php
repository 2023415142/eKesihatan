@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2 data-i18n="Patient Dashboard">Patient Dashboard</h2>
        <p data-i18n="Manage your appointments and health services.">Manage your appointments and health services.</p>
    </div>
    <a class="button-link" href="{{ route('patient.appointments.create') }}" data-i18n="Book Appointment">Book Appointment</a>
</div>

@php
    $nextAppointment = $appointments->first();
@endphp

<div class="stat-grid">
    <div class="stat-card">
        <span data-i18n="Upcoming Appointments">Upcoming Appointments</span>
        <strong>{{ $appointments->count() }}</strong>
    </div>
    <div class="stat-card">
        <span data-i18n="Next Appointment">Next Appointment</span>
        <strong>{{ $nextAppointment ? $nextAppointment->scheduled_at->format('d M, h:i A') : '—' }}</strong>
    </div>
    <div class="stat-card">
        <span data-i18n="Assigned Doctor">Assigned Doctor</span>
        <strong>{{ $nextAppointment ? $nextAppointment->doctor->name : '—' }}</strong>
    </div>
</div>

<section>
    <h3 data-i18n="Upcoming Appointments">Upcoming Appointments</h3>
    <div class="card-grid">
        @forelse ($appointments as $appointment)
            @php
                $statusClass = match ($appointment->status) {
                    'approved', 'checked-in' => 'success',
                    'cancelled', 'rejected' => 'danger',
                    default => 'warning',
                };
            @endphp
            <article class="info-card">
                <div class="info-card__header">
                    <h3>{{ $appointment->scheduled_at->format('d M Y') }}</h3>
                    <span class="status-chip {{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
                </div>
                <p><strong data-i18n="Time">Time</strong>: {{ $appointment->scheduled_at->format('h:i A') }}</p>
                <p><strong data-i18n="Doctor">Doctor</strong>: {{ $appointment->doctor->name }}</p>
                <p><strong data-i18n="Service">Service</strong>: {{ $appointment->service?->name ?? 'General' }}</p>
                <a class="card-link" href="{{ route('patient.appointments.show', $appointment) }}" data-i18n="View">View</a>
            </article>
        @empty
            <p data-i18n="No upcoming appointments.">No upcoming appointments.</p>
        @endforelse
    </div>
</section>

<section>
    <h3 data-i18n="Appointment Calendar">Appointment Calendar</h3>
    <div class="calendar-grid">
        @forelse ($appointments->groupBy(fn($appt) => $appt->scheduled_at->format('Y-m-d')) as $date => $dateAppointments)
            <div class="calendar-day">
                <h4>{{ \Carbon\Carbon::parse($date)->format('D, d M') }}</h4>
                @foreach ($dateAppointments as $appointment)
                    <div class="calendar-event">
                        <strong>{{ $appointment->scheduled_at->format('h:i A') }}</strong>
                        <div>{{ $appointment->service?->name ?? 'General' }}</div>
                        <div>{{ $appointment->doctor->name }}</div>
                    </div>
                @endforeach
            </div>
        @empty
            <p data-i18n="No upcoming appointments.">No upcoming appointments.</p>
        @endforelse
    </div>
</section>
@endsection