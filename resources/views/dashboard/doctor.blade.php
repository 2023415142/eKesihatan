@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2 data-i18n="Doctor Dashboard">Doctor Dashboard</h2>
        <p data-i18n="Today's appointments for">Today's appointments for</p>
        <strong>{{ now()->format('d M Y') }}</strong>
    </div>
    <a class="button-link secondary" href="{{ route('staff.patients.index') }}" data-i18n="Patient Directory">Patient Directory</a>
</div>

@php
    $completedCount = $appointments->where('status', 'completed')->count();
    $noShowCount = $appointments->where('status', 'no-show')->count();
@endphp

<div class="stat-grid">
    <div class="stat-card">
        <span data-i18n="Today's Appointments:">Today's Appointments:</span>
        <strong>{{ $appointments->count() }}</strong>
    </div>
    <div class="stat-card">
        <span data-i18n="Completed">Completed</span>
        <strong>{{ $completedCount }}</strong>
    </div>
    <div class="stat-card">
        <span data-i18n="No-show">No-show</span>
        <strong>{{ $noShowCount }}</strong>
    </div>
</div>

<section>
    <h3 data-i18n="Daily Schedule">Daily Schedule</h3>
    <div class="calendar-grid">
        <div class="calendar-day">
            <h4>{{ now()->format('D, d M') }}</h4>
            @forelse ($appointments as $appointment)
                <div class="calendar-event">
                    <strong>{{ $appointment->scheduled_at->format('h:i A') }}</strong>
                    <div>{{ $appointment->patient->name }}</div>
                    <div>{{ $appointment->service?->name ?? 'General' }}</div>
                    <span class="status-chip {{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'no-show' ? 'danger' : 'warning') }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            @empty
                <p data-i18n="No appointments scheduled.">No appointments scheduled.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection