@extends('layouts.app')

@section('content')
<h2 data-i18n="Forms & Downloads">Forms & Downloads</h2>
<a href="{{ route('admin.forms.create') }}" data-i18n="Add Form">Add Form</a>

@if (!empty($downloadableFormsTableMissing))
    <div class="alert alert-danger" data-i18n="Forms table is missing. Run php artisan migrate first.">
        Forms table is missing. Run php artisan migrate first.
    </div>
@endif

<table>
    <thead>
        <tr>
            <th data-i18n="Title">Title</th>
            <th data-i18n="Display Order">Display Order</th>
            <th data-i18n="Status">Status</th>
            <th data-i18n="Actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($forms as $form)
            <tr>
                <td>{{ $form->title }}</td>
                <td>{{ $form->sort_order }}</td>
                <td data-i18n="{{ $form->is_published ? 'Published' : 'Draft' }}">{{ $form->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a href="{{ asset($form->file_path) }}" target="_blank" rel="noopener noreferrer" data-i18n="Open File">Open File</a>
                    <a href="{{ route('admin.forms.edit', $form) }}" data-i18n="Edit">Edit</a>
                    <form action="{{ route('admin.forms.destroy', $form) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-i18n="Delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" data-i18n="No forms created.">No forms created.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
