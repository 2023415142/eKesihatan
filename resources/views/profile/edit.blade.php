@extends('layouts.app')
 
@section('content')
<h2 data-i18n="Update Profile">Update Profile</h2>
 
<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')
    <div>
        <label for="name" data-i18n="Name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
    </div>
    <div>
        <label for="email" data-i18n="Email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div>
        <label for="phone_number" data-i18n="Phone Number">Phone Number</label>
        <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}">
    </div>
    @if ($user->isPatient())
        <div>
            <label for="student_id" data-i18n="Student ID">Student ID</label>
            <input id="student_id" name="student_id" type="text" value="{{ old('student_id', $user->student_id) }}">
        </div>
    @endif
    @if (!$user->isPatient())
        <div>
            <label for="staff_id" data-i18n="Staff ID">Staff ID</label>
            <input id="staff_id" name="staff_id" type="text" value="{{ old('staff_id', $user->staff_id) }}">
        </div>
    @endif
    @if ($user->isDoctor())
        <div>
            <label for="specialization" data-i18n="Specialization (Doctor)">Specialization (Doctor)</label>
            <input id="specialization" name="specialization" type="text" value="{{ old('specialization', $user->specialization) }}">
        </div>
    @endif
    <div>
        <label for="password" data-i18n="New Password (optional)">New Password (optional)</label>
        <input id="password" name="password" type="password">
    </div>
    <div>
        <label for="password_confirmation" data-i18n="Confirm Password">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password">
    </div>
    <button type="submit" data-i18n="Save Changes">Save Changes</button>
</form>
@endsection