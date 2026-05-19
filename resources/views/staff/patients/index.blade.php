@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2 data-i18n="Patient Directory">Patient Directory</h2>
        <p data-i18n="View patient demographic and emergency details.">View patient demographic and emergency details.</p>
    </div>
</div>

<section class="card-grid">
    @forelse ($patients as $patient)
        <article class="info-card">
            <div class="info-card__header">
                <h3>{{ $patient->name }}</h3>
                <span class="status-chip">{{ $patient->blood_type ?: 'N/A' }}</span>
            </div>
            <p><strong data-i18n="Student ID">Student ID</strong>: {{ $patient->student_id ?? '—' }}</p>
            <p><strong data-i18n="Phone Number">Phone Number</strong>: {{ $patient->phone_number ?? '—' }}</p>
            <p><strong data-i18n="Emergency Contact">Emergency Contact</strong>: {{ $patient->emergency_contact_name ?? '—' }}</p>
            <a class="card-link" href="{{ route('staff.patients.show', $patient) }}" data-i18n="View Details">View Details</a>
        </article>
    @empty
        <p data-i18n="No patients found.">No patients found.</p>
    @endforelse
</section>
@endsection
