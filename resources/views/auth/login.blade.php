@extends('layouts.app')
 
@section('content')
<h2>Login</h2>
<form method="POST" action="{{ route('login.attempt') }}">
    @csrf
    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>
    <button type="submit">Login</button>
</form>
@endsection
