@extends('layouts.app')

@section('content')
<h2>Patient History</h2>
<p>{{ $patient->name }}</p>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Doctor</th>
            <th>Service</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->scheduled_at->format('d M Y') }}</td>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->service?->name ?? 'General' }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
            </tr>
        @empty
            <tr><td colspan="4">No appointment history.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection