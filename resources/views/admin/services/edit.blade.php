@extends('layouts.app')
 
@section('content')
<h2>Edit Health Service</h2>
<form method="POST" action="{{ route('admin.services.update', $service) }}">
    @csrf
    @method('PUT')
    <div>
        <label for="name">Service Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $service->name) }}" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $service->description) }}</textarea>
    </div>
    <div>
        <label for="duration_minutes">Duration (minutes)</label>
        <input id="duration_minutes" name="duration_minutes" type="number" min="5" max="240" value="{{ old('duration_minutes', $service->duration_minutes) }}" required>
    </div>
    <div>
        <label for="is_active">
            <input id="is_active" name="is_active" type="checkbox" @checked($service->is_active)>
            Active
        </label>
    </div>
    <button type="submit">Update Service</button>
</form>
@endsection
