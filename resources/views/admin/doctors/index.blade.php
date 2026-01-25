@extends('layouts.app')

@section('content')
<h2>Doctors</h2>
<a href="{{ route('admin.doctors.create') }}">Add Doctor</a>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Specialization</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($doctors as $doctor)
            <tr>
                <td>{{ $doctor->name }}</td>
                <td>{{ $doctor->email }}</td>
                <td>{{ $doctor->specialization ?? 'General' }}</td>
                <td>{{ $doctor->phone_number ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.doctors.edit', $doctor) }}">Edit</a>
                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No doctors added.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection