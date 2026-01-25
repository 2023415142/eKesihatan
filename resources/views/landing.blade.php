@extends('layouts.app')
 
@section('content')
<section>
    <h2>Welcome to eKesihatan</h2>
    <p>eKesihatan is the appointment booking system for Unit Kesihatan UiTM Perlis. Students and staff can schedule, manage, and track clinic visits with reduced waiting time.</p>
    <div>
        <a href="{{ route('register') }}">Create Patient Account</a>
        <a href="{{ route('login') }}">Login</a>
    </div>
</section>
 
<section>
    <h3>Objectives</h3>
    <ol>
        <li>Enable students and staff to schedule and manage medical appointments conveniently.</li>
        <li>Reduce waiting time and overcrowding by issuing queue numbers before arrival.</li>
        <li>Help Unit Kesihatan staff forecast daily patient flow and optimize resources.</li>
    </ol>
</section>
 
<section>
    <h3>Key Features</h3>
    <ul>
        <li>Role-based dashboards for Admin, Doctor, and Patient.</li>
        <li>Appointment booking with SMS confirmation and reminders.</li>
        <li>QR check-in to place patients in the daily queue.</li>
        <li>BMI calculator and translation helper.</li>
        <li>Secure storage of medical documents and certificates.</li>
    </ul>
</section>
@endsection
