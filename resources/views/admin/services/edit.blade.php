@extends('layouts.app')
 
@section('content')
<h2 data-i18n="Edit Appointment Slot">Edit Appointment Slot</h2>
<form method="POST" action="{{ route('admin.slots.update', $slot) }}">
    @csrf
    @method('PUT')
    <div>
        <label for="doctor_id" data-i18n="Doctor">Doctor</label>
        <select id="doctor_id" name="doctor_id" required>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" @selected($slot->doctor_id === $doctor->id)>{{ $doctor->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="slot_date" data-i18n="Date">Date</label>
        <input id="slot_date" name="slot_date" type="date" value="{{ old('slot_date', $slot->slot_date->format('Y-m-d')) }}" required>
    </div>
    <div>
        <label for="start_time" data-i18n="Start Time">Start Time</label>
        <input id="start_time" name="start_time" type="time" value="{{ old('start_time', $slot->start_time) }}" required>
    </div>
    <div>
        <label for="end_time" data-i18n="End Time">End Time</label>
        <input id="end_time" name="end_time" type="time" value="{{ old('end_time', $slot->end_time) }}" required>
    </div>
    <div>
        <label for="capacity" data-i18n="Capacity">Capacity</label>
        <input id="capacity" name="capacity" type="number" min="1" max="20" value="{{ old('capacity', $slot->capacity) }}" required>
    </div>
    <div>
        <label for="location" data-i18n="Location">Location</label>
        <input id="location" name="location" type="text" value="{{ old('location', $slot->location) }}">
    </div>
    <div>
        <input type="hidden" name="is_active" value="0">
        <label for="is_active">
            <input id="is_active" name="is_active" type="checkbox" value="1" @checked($slot->is_active)>
            <span data-i18n="Active">Active</span>
        </label>
    </div>
    <button type="submit" data-i18n="Update Slot">Update Slot</button>
</form>
@endsection