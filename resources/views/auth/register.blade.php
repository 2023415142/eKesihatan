@extends('layouts.app')

@section('content')
<h2 data-i18n="Patient Registration">Patient Registration</h2>
<form method="POST" action="{{ route('register.store') }}">
    @csrf
    <div>
        <label for="name" data-i18n="Full Name">Full Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
    </div>
    <div>
        <label for="student_id" data-i18n="Student ID">Student ID</label>
        <input id="student_id" name="student_id" type="text" value="{{ old('student_id') }}" required>
    </div>
    <div>
        <label for="email" data-i18n="Email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="phone_number" data-i18n="Phone Number">Phone Number</label>
        <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') }}" required>
    </div>
    <div>
        <label for="password" data-i18n="Password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>
    <div>
        <label for="password_confirmation" data-i18n="Confirm Password">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>
    </div>
    <button type="submit" data-i18n="Register">Register</button>
</form>
@endsection