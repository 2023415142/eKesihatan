@extends('layouts.app')

@section('content')
<h2>Reschedule Appointment</h2>

<form method="POST" action="{{ route('patient.appointments.update', $appointment) }}">
    @csrf
    @method('PUT')
    <div>
        <label for="appointment_slot_id">New Appointment Slot</label>
        <select id="appointment_slot_id" name="appointment_slot_id" required>
            @foreach ($slots as $slot)
                <option value="{{ $slot->id }}" @selected($appointment->appointment_slot_id === $slot->id)>
                    {{ $slot->slot_date->format('d M Y') }} {{ $slot->start_time }} - {{ $slot->end_time }}
                    (Dr. {{ $slot->doctor->name }})
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit">Update Appointment</button>
</form>
@endsection