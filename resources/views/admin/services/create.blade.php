@extends('layouts.app')
 
@section('content')
<h2>Add Health Service</h2>
<form method="POST" action="{{ route('admin.services.store') }}">
    @csrf
    <div>
        <label for="name">Service Name</label>
        <input id="name" name="name" type="text" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3"></textarea>
    </div>
    <div>
        <label for="duration_minutes">Duration (minutes)</label>
        <input id="duration_minutes" name="duration_minutes" type="number" min="5" max="240" value="15" required>
    </div>
    <div>
        <label for="is_active">
            <input id="is_active" name="is_active" type="checkbox" checked>
            Active
        </label>
    </div>
    <button type="submit">Create Service</button>
</form>
@endsection
