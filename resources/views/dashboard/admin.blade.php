@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2 data-i18n="Admin Dashboard">Admin Dashboard</h2>
        <p data-i18n="Manage services, doctors, appointment slots, and approvals.">Manage services, doctors, appointment slots, and approvals.</p>
        <span class="subtitle" data-i18n="University Health Operations Overview">University Health Operations Overview</span>
    </div>
    <span class="status-chip" data-i18n="Today">Today</span>
</div>

<section class="dashboard-grid">
    <article class="profile-card admin-profile">
        <div class="profile-avatar" aria-hidden="true">{{ $profileInitials ?: 'UK' }}</div>
        <h3>{{ auth()->user()->name }}</h3>
        <p>{{ auth()->user()->email }}</p>
        <p>{{ auth()->user()->phone_number ?? '—' }}</p>
        <div class="profile-meta">
            <span data-i18n="Role">Role</span>
            <strong data-i18n="Administrator">Administrator</strong>
        </div>
    </article>

    <article class="info-card detail-card">
        <div class="detail-card__header">
            <h4 data-i18n="Operations Summary">Operations Summary</h4>
        </div>
        <div class="detail-grid">
            <div>
                <span data-i18n="Pending Appointments:">Pending Appointments:</span>
                <strong>{{ $pendingAppointments }}</strong>
            </div>
            <div>
                <span data-i18n="Today's Appointments:">Today's Appointments:</span>
                <strong>{{ $todayAppointments }}</strong>
            </div>
            <div>
                <span data-i18n="Active Services:">Active Services:</span>
                <strong>{{ $servicesCount }}</strong>
            </div>
            <div>
                <span data-i18n="Doctors:">Doctors:</span>
                <strong>{{ $doctorsCount }}</strong>
            </div>
        </div>
    </article>

    <article class="info-card detail-card">
        <div class="detail-card__header">
            <h4 data-i18n="Quick Actions">Quick Actions</h4>
        </div>
        <div class="action-grid">
            <a class="action-link" href="{{ route('admin.services.index') }}" data-i18n="Manage Health Services">Manage Health Services</a>
            <a class="action-link" href="{{ route('admin.doctors.index') }}" data-i18n="Manage Doctors">Manage Doctors</a>
            <a class="action-link" href="{{ route('admin.slots.index') }}" data-i18n="Manage Appointment Slots">Manage Appointment Slots</a>
            <a class="action-link" href="{{ route('admin.appointments.index') }}" data-i18n="Manage Appointments">Manage Appointments</a>
            <a class="action-link secondary" href="{{ route('staff.patients.index') }}" data-i18n="Patient Directory">Patient Directory</a>
        </div>
    </article>
</section>

<section>
    <div class="section-header">
        <div>
            <h3 data-i18n="Doctor Availability Calendar">Doctor Availability Calendar</h3>
            <p data-i18n="Review weekly slot coverage and spot leave or off-campus duties.">
                Review weekly slot coverage and spot leave or off-campus duties.
            </p>
        </div>
        <span class="status-chip warning" data-i18n="No slots = Unavailable">No slots = Unavailable</span>
    </div>
    <div class="calendar-board">
        <div class="calendar-board__row calendar-board__header">
            <div class="calendar-board__doctor" data-i18n="Doctor">Doctor</div>
            @foreach ($calendarDays as $day)
                <div class="calendar-board__cell">
                    <span class="calendar-board__weekday">{{ $day->format('D') }}</span>
                    <span class="calendar-board__date">{{ $day->format('d M') }}</span>
                </div>
            @endforeach
        </div>
        @foreach ($calendarDoctors as $doctor)
            <div class="calendar-board__row">
                <div class="calendar-board__doctor">
                    <strong>{{ $doctor->name }}</strong>
                    <span>{{ $doctor->specialization ?? 'General' }}</span>
                </div>
                @foreach ($calendarDays as $day)
                    @php
                        $key = $doctor->id . '|' . $day->format('Y-m-d');
                        $slots = $slotMap->get($key, collect());
                    @endphp
                    <div class="calendar-board__cell">
                        @if ($slots->isEmpty())
                            <span class="status-chip danger" data-i18n="No slots">No slots</span>
                            <div class="calendar-board__note" data-i18n="Unavailable">Unavailable</div>
                        @else
                            <span class="status-chip success">{{ $slots->count() }} <span data-i18n="slots">slots</span></span>
                            <div class="calendar-board__times">
                                @foreach ($slots as $slot)
                                    <span>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
@endsection