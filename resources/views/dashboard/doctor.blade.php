@extends('layouts.app')

@section('content')
<h2>Doctor Dashboard</h2>
<section>
    <h3>Today's Appointments ({{ now()->format('d M Y') }})</h3>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>Patient</th>
                <th>Service</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->scheduled_at->format('h:i A') }}</td>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->service?->name ?? 'General' }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No appointments scheduled.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection