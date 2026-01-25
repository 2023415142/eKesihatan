@extends('layouts.app')
 
@section('content')
<h2>Patient Registration</h2>
<form method="POST" action="{{ route('register.store') }}">
    @csrf
    <div>
        <label for="name">Full Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
    </div>
    <div>
        <label for="student_id">Student ID</label>
        <input id="student_id" name="student_id" type="text" value="{{ old('student_id') }}" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="phone_number">Phone Number</label>
        <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') }}" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>
    </div>
    <button type="submit">Register</button>
</form>
@endsection
