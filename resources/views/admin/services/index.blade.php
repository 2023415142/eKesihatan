@extends('layouts.app')

@section('content')
<h2>Health Services</h2>
<a href="{{ route('admin.services.create') }}">Add Service</a>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->duration_minutes }} mins</td>
                <td>{{ $service->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.services.edit', $service) }}">Edit</a>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">No services created.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection