@extends('layouts.app')

@section('content')
<h2>Patient Dashboard</h2>
<p>Manage your appointments and health services.</p>

<h3>Upcoming Appointments</h3>
<table>
    <thead>
        <tr>
            <th>Date</th><th>Time</th><th>Doctor</th><th>Service</th><th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->scheduled_at->format('d M Y') }}</td>
                <td>{{ $appointment->scheduled_at->format('h:i A') }}</td>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->service?->name ?? 'General' }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No upcoming appointments.</td></tr>
        @endforelse
    </tbody>
</table>

<section class="bmi-card">
    <h3>BMI Calculator</h3>
    <form method="POST" action="{{ route('patient.bmi.calculate') }}">
        @csrf
        <input type="hidden" name="redirect" value="dashboard">
        <div>
            <label for="bmi-sex">Gender</label>
            <select id="bmi-sex" name="sex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div>
            <label for="bmi-age">Age</label>
            <input id="bmi-age" name="age" type="number" min="1" max="120" required>
        </div>
        <div>
            <label for="bmi-height">Height (cm)</label>
            <input id="bmi-height" name="height_cm" type="number" step="0.1" required>
        </div>
        <div>
            <label for="bmi-weight">Weight (kg)</label>
            <input id="bmi-weight" name="weight_kg" type="number" step="0.1" required>
        </div>
        <button type="submit">Calculate BMI</button>
    </form>

    @if (session('bmi_result'))
        <div class="bmi-result">
            <p><strong>Your BMI:</strong> {{ session('bmi_result.bmi') }}</p>
            <p><strong>Category:</strong> {{ session('bmi_result.category') }}</p>
            <p><strong>Age:</strong> {{ session('bmi_result.age') }}</p>
            <p><strong>Gender:</strong> {{ ucfirst(session('bmi_result.sex')) }}</p>
        </div>
    @endif
</section>
@endsection