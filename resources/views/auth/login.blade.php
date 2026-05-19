@extends('layouts.app')

@section('content')
<h2 data-i18n="Login">Login</h2>
<form method="POST" action="{{ route('login.attempt') }}">
    @csrf
    <div>
        <label for="email" data-i18n="Email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="role" data-i18n="Role">Role</label>
        <select id="role" name="role" required>
            <option value="patient" @selected(old('role') === 'patient') data-i18n="Patient">Patient</option>
            <option value="doctor" @selected(old('role') === 'doctor') data-i18n="Doctor">Doctor</option>
            <option value="admin" @selected(old('role') === 'admin') data-i18n="Admin">Admin</option>
        </select>
    </div>
    <div>
        <label for="password" data-i18n="Password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>
    <button type="submit" data-i18n="Login">Login</button>
</form>
@endsection