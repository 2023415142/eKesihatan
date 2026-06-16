@extends('layouts.app')

@section('content')
<h2 data-i18n="Clinic Bulletins">Clinic Bulletins</h2>
<a href="{{ route('admin.bulletins.create') }}" data-i18n="Add Bulletin">Add Bulletin</a>

<table>
    <thead>
        <tr>
            <th data-i18n="Title">Title</th>
            <th data-i18n="Date">Date</th>
            <th data-i18n="Status">Status</th>
            <th data-i18n="Actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bulletins as $bulletin)
            <tr>
                <td>{{ $bulletin->title }}</td>
                <td>{{ $bulletin->event_date ? $bulletin->event_date->format('d M Y') : '—' }}</td>
                <td data-i18n="{{ $bulletin->is_published ? 'Published' : 'Draft' }}">{{ $bulletin->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a href="{{ route('admin.bulletins.edit', $bulletin) }}" data-i18n="Edit">Edit</a>
                    <form action="{{ route('admin.bulletins.destroy', $bulletin) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-i18n="Delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" data-i18n="No bulletins created.">No bulletins created.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
