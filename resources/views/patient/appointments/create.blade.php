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
        <label for="doctor_id">Doctor</label>
        <select id="doctor_id" name="doctor_id" required>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization ?? 'General' }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="appointment_slot_id">Appointment Slot</label>
        <select id="appointment_slot_id" name="appointment_slot_id" required>
            @foreach ($slots as $slot)
                <option value="{{ $slot->id }}">
                    {{ $slot->slot_date->format('d M Y') }} {{ $slot->start_time }} - {{ $slot->end_time }}
                    (Dr. {{ $slot->doctor->name }})
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="notes">Notes (optional)</label>
        <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
    </div>
    <button type="submit">Submit Booking</button>
</form>
@endsection
