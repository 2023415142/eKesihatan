@extends('layouts.app')
 
@section('content')
<h2>Add Appointment Slot</h2>
<form method="POST" action="{{ route('admin.slots.store') }}">
    @csrf
    <div>
        <label for="doctor_id">Doctor</label>
        <select id="doctor_id" name="doctor_id" required>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="slot_date">Date</label>
        <input id="slot_date" name="slot_date" type="date" required>
    </div>
    <div>
        <label for="start_time">Start Time</label>
        <input id="start_time" name="start_time" type="time" required>
    </div>
    <div>
        <label for="end_time">End Time</label>
        <input id="end_time" name="end_time" type="time" required>
    </div>
    <div>
        <label for="capacity">Capacity</label>
        <input id="capacity" name="capacity" type="number" min="1" max="20" value="1" required>
    </div>
    <div>
        <label for="location">Location</label>
        <input id="location" name="location" type="text">
    </div>
    <div>
        <label for="is_active">
            <input id="is_active" name="is_active" type="checkbox" checked>
            Active
        </label>
    </div>
    <button type="submit">Create Slot</button>
</form>
@endsection
