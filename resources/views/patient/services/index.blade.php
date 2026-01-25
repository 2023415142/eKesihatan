@extends('layouts.app')
 
@section('content')
<h2>Health Services</h2>
 
<table>
    <thead>
        <tr>
            <th>Service</th>
            <th>Description</th>
            <th>Duration (mins)</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->description }}</td>
                <td>{{ $service->duration_minutes }}</td>
            </tr>
        @empty
            <tr><td colspan="3">No active services.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
