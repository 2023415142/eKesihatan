@extends('layouts.app')
 
@section('content')
<h2>BMI Calculator</h2>
 
<form method="POST" action="{{ route('patient.bmi.calculate') }}">
    @csrf
    <div>
        <label for="height_cm">Height (cm)</label>
        <input id="height_cm" name="height_cm" type="number" step="0.1" value="{{ old('height_cm', $height_cm ?? '') }}" required>
    </div>
    <div>
        <label for="weight_kg">Weight (kg)</label>
        <input id="weight_kg" name="weight_kg" type="number" step="0.1" value="{{ old('weight_kg', $weight_kg ?? '') }}" required>
    </div>
    <button type="submit">Calculate BMI</button>
</form>
 
@isset($bmi)
    <div>
        <p><strong>Your BMI:</strong> {{ $bmi }}</p>
        <p><strong>Category:</strong> {{ $category }}</p>
    </div>
@endisset
@endsection
