@extends('layouts.app')
 
@section('content')
<h2>Appointment Slots</h2>
<a href="{{ route('admin.slots.create') }}">Add Slot</a>
 
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor</th>
            <th>Capacity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($slots as $slot)
            <tr>
                <td>{{ $slot->slot_date->format('d M Y') }}</td>
                <td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
                <td>{{ $slot->doctor->name }}</td>
                <td>{{ $slot->capacity }}</td>
                <td>{{ $slot->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.slots.edit', $slot) }}">Edit</a>
                    <form action="{{ route('admin.slots.destroy', $slot) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No appointment slots created.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
