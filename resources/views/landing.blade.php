@extends('layouts.app')

@section('content')
<section>
    <h2 data-i18n="Welcome to eKesihatan">Welcome to eKesihatan</h2>
    <p data-i18n="eKesihatan is the appointment booking system for Unit Kesihatan UiTM Perlis. Students and staff can schedule, manage, and track clinic visits with reduced waiting time.">
        eKesihatan is the appointment booking system for Unit Kesihatan UiTM Perlis. Students and staff can schedule, manage, and track clinic visits with reduced waiting time.
    </p>
    <div>
        <a href="{{ route('register') }}" data-i18n="Create Patient Account">Create Patient Account</a>
        <a href="{{ route('login') }}" data-i18n="Login">Login</a>
    </div>
</section>

<section>
    <h3 data-i18n="Objectives">Objectives</h3>
    <ol>
        <li data-i18n="Enable students and staff to schedule and manage medical appointments conveniently.">Enable students and staff to schedule and manage medical appointments conveniently.</li>
        <li data-i18n="Reduce waiting time and overcrowding by issuing queue numbers before arrival.">Reduce waiting time and overcrowding by issuing queue numbers before arrival.</li>
        <li data-i18n="Help Unit Kesihatan staff forecast daily patient flow and optimize resources.">Help Unit Kesihatan staff forecast daily patient flow and optimize resources.</li>
    </ol>
</section>

<section>
    <h3 data-i18n="Key Features">Key Features</h3>
    <ul>
        <li data-i18n="Role-based dashboards for Admin, Doctor, and Patient.">Role-based dashboards for Admin, Doctor, and Patient.</li>
        <li data-i18n="Appointment booking with SMS confirmation and reminders.">Appointment booking with SMS confirmation and reminders.</li>
        <li data-i18n="QR check-in to mark attendance and reduce no-show cases.">QR check-in to mark attendance and reduce no-show cases.</li>
        <li data-i18n="BMI calculator and language toggle.">BMI calculator and language toggle.</li>
        <li data-i18n="Secure storage of medical documents and certificates.">Secure storage of medical documents and certificates.</li>
    </ul>
</section>
@endsection