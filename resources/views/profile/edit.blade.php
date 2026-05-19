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
        <div>
            <label for="blood_type" data-i18n="Blood Type">Blood Type</label>
            <select id="blood_type" name="blood_type">
                <option value="" data-i18n="Select Blood Type">Select Blood Type</option>
                @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                    <option value="{{ $type }}" @selected(old('blood_type', $user->blood_type) === $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="emergency_contact_name" data-i18n="Emergency Contact Name">Emergency Contact Name</label>
            <input id="emergency_contact_name" name="emergency_contact_name" type="text" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}">
        </div>
        <div>
            <label for="emergency_contact_phone" data-i18n="Emergency Contact Phone">Emergency Contact Phone</label>
            <input id="emergency_contact_phone" name="emergency_contact_phone" type="text" value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}">
        </div>
        <div>
            <label for="emergency_contact_relationship" data-i18n="Emergency Contact Relationship">Emergency Contact Relationship</label>
            <input id="emergency_contact_relationship" name="emergency_contact_relationship" type="text" value="{{ old('emergency_contact_relationship', $user->emergency_contact_relationship) }}">
        </div>
        <div>
            <label for="allergies" data-i18n="Allergies or Medical Notes">Allergies or Medical Notes</label>
            <textarea id="allergies" name="allergies" rows="3">{{ old('allergies', $user->allergies) }}</textarea>
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