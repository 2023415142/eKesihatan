@extends('layouts.app')
 
@section('content')
<h2>Update Profile</h2>
 
<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')
    <div>
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div>
        <label for="phone_number">Phone Number</label>
        <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}">
    </div>
    <div>
        <label for="student_id">Student ID</label>
        <input id="student_id" name="student_id" type="text" value="{{ old('student_id', $user->student_id) }}">
    </div>
    <div>
        <label for="staff_id">Staff ID</label>
        <input id="staff_id" name="staff_id" type="text" value="{{ old('staff_id', $user->staff_id) }}">
    </div>
    <div>
        <label for="specialization">Specialization (Doctor)</label>
        <input id="specialization" name="specialization" type="text" value="{{ old('specialization', $user->specialization) }}">
    </div>
    <div>
        <label for="password">New Password (optional)</label>
        <input id="password" name="password" type="password">
    </div>
    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password">
    </div>
    <button type="submit">Save Changes</button>
</form>
@endsection
