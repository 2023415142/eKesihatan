@section('content')
<h2 data-i18n="Edit Health Service">Edit Health Service</h2>
<form method="POST" action="{{ route('admin.services.update', $service) }}">
    @csrf
    @method('PUT')
    <div>
        <label for="name" data-i18n="Service Name">Service Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $service->name) }}" required>
    </div>
    <div>
        <label for="description" data-i18n="Description">Description</label>
        <textarea id="description" name="description" rows="3">{{ old('description', $service->description) }}</textarea>
    </div>
    <div>
        <label for="duration_minutes" data-i18n="Duration (minutes)">Duration (minutes)</label>
        <input id="duration_minutes" name="duration_minutes" type="number" min="5" max="240" value="{{ old('duration_minutes', $service->duration_minutes) }}" required>
    </div>
    <div>
        <input type="hidden" name="is_active" value="0">
        <label for="is_active">
            <input id="is_active" name="is_active" type="checkbox" value="1" @checked($service->is_active)>
            <span data-i18n="Active">Active</span>
        </label>
    </div>
    <button type="submit" data-i18n="Update Service">Update Service</button>
</form>
@endsection