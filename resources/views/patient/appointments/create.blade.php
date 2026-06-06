@extends('layouts.app')

@section('content')
<h2>Book Appointment</h2>

<form method="POST" action="{{ route('patient.appointments.store') }}">
    @csrf
    <div>
        <label for="health_service_id">Health Service</label>
        <select id="health_service_id" name="health_service_id" required>
            @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="doctor_id" data-i18n="Preferred Doctor (optional)">Preferred Doctor (optional)</label>
        <select id="doctor_id" name="doctor_id">
            <option value="" data-i18n="Any available doctor">Any available doctor</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization ?? 'General' }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="preferred_date" data-i18n="Preferred Date">Preferred Date</label>
        <input id="preferred_date" name="preferred_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('preferred_date') }}" required>
    </div>
    <div>
        <label for="notes">Notes (optional)</label>
        <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
    </div>
    <p><strong data-i18n="Auto-assignment:">Auto-assignment:</strong> <span data-i18n="The system will pick the earliest available slot on or after your preferred date while balancing doctor workload.">The system will pick the earliest available slot on or after your preferred date while balancing doctor workload.</span></p>
    <button type="submit">Submit Booking</button>
</form>

<section>
    <h3>SMS & Queue</h3>
    <p>You will receive an SMS confirmation and your queue number once your booking is submitted.</p>
</section>
@endsection