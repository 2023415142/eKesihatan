@extends('layouts.app')

@section('content')
<h2>Reschedule Appointment</h2>

<form method="POST" action="{{ route('patient.appointments.update', $appointment) }}">
    @csrf
    @method('PUT')
    <div>
        <label for="doctor_id" data-i18n="Preferred Doctor (optional)">Preferred Doctor (optional)</label>
        <select id="doctor_id" name="doctor_id">
            <option value="" data-i18n="Any available doctor">Any available doctor</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" @selected($appointment->doctor_id === $doctor->id)>{{ $doctor->name }} ({{ $doctor->specialization ?? 'General' }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="preferred_date" data-i18n="Preferred Date">Preferred Date</label>
        <input id="preferred_date" name="preferred_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('preferred_date', $appointment->scheduled_at->format('Y-m-d')) }}" required>
    </div>
    <p><strong data-i18n="Auto-assignment:">Auto-assignment:</strong> <span data-i18n="The system will pick the earliest available slot on or after your preferred date while balancing doctor workload.">The system will pick the earliest available slot on or after your preferred date while balancing doctor workload.</span></p>
    <button type="submit">Update Appointment</button>
</form>
@endsection