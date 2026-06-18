@extends('layouts.app')

@section('content')
<h2 data-i18n="Add Form">Add Form</h2>

<form method="POST" action="{{ route('admin.forms.store') }}" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="title" data-i18n="Form Title">Form Title</label>
        <input id="title" name="title" type="text" value="{{ old('title') }}" required>
    </div>

    <div>
        <label for="description" data-i18n="Description">Description</label>
        <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
    </div>

    <div>
        <label for="sort_order" data-i18n="Display Order">Display Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0" max="9999" value="{{ old('sort_order', 0) }}">
    </div>

    <div>
        <label for="form_file" data-i18n="Form File (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX)">Form File (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX)</label>
        <input id="form_file" name="form_file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" required>
    </div>

    <div>
        <label for="is_published" data-i18n="Publish for Download">Publish for Download</label>
        <input id="is_published" name="is_published" type="checkbox" value="1" @checked(old('is_published', true))>
    </div>

    <button type="submit" data-i18n="Save Form">Save Form</button>
</form>
@endsection
