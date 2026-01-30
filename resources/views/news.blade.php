@extends('layouts.app')

@section('content')
<section>
    <h2 data-i18n="Latest News & Information">Latest News & Information</h2>
    <p data-i18n="Stay updated with clinic announcements, system enhancements, and health campaigns.">
        Stay updated with clinic announcements, system enhancements, and health campaigns.
    </p>
    <div class="hero-highlights">
        <div class="highlight-card">
            <strong data-i18n="System Update">System Update</strong>
            <p data-i18n="Faster appointment booking and rescheduling are now available across the app.">
                Faster appointment booking and rescheduling are now available across the app.
            </p>
        </div>
        <div class="highlight-card">
            <strong data-i18n="Queue Check-In Reminder">Queue Check-In Reminder</strong>
            <p data-i18n="Your QR check-in screen now highlights the counter time window.">
                Your QR check-in screen now highlights the counter time window.
            </p>
        </div>
        <div class="highlight-card">
            <strong data-i18n="Document Upload Ready">Document Upload Ready</strong>
            <p data-i18n="Upload medical certificates directly after your appointment.">
                Upload medical certificates directly after your appointment.
            </p>
        </div>
    </div>
</section>

<section>
    <h3 data-i18n="System Updates">System Updates</h3>
    <div class="articles-grid">
        <article class="article-card">
            <div class="article-content">
                <h4 data-i18n="Improved Appointment Timeline">Improved Appointment Timeline</h4>
                <p data-i18n="Track approval, queue number, and check-in status in one timeline.">
                    Track approval, queue number, and check-in status in one timeline.
                </p>
                <span class="article-meta" data-i18n="Released January 2026">Released January 2026</span>
            </div>
        </article>
        <article class="article-card">
            <div class="article-content">
                <h4 data-i18n="Smarter Slot Availability">Smarter Slot Availability</h4>
                <p data-i18n="View live slot capacity before booking to reduce wait time.">
                    View live slot capacity before booking to reduce wait time.
                </p>
                <span class="article-meta" data-i18n="Released December 2025">Released December 2025</span>
            </div>
        </article>
        <article class="article-card">
            <div class="article-content">
                <h4 data-i18n="Profile Health Summary">Profile Health Summary</h4>
                <p data-i18n="Update allergies, emergency contact, and medical notes in your profile.">
                    Update allergies, emergency contact, and medical notes in your profile.
                </p>
                <span class="article-meta" data-i18n="Released November 2025">Released November 2025</span>
            </div>
        </article>
    </div>
</section>

<section>
    <h3 data-i18n="Clinic Announcements">Clinic Announcements</h3>
    <div class="notice-board">
        <article class="notice-card">
            <h4 data-i18n="Extended Counter Hours">Extended Counter Hours</h4>
            <p data-i18n="Counter service is open until 5:30 PM on Mondays and Wednesdays.">
                Counter service is open until 5:30 PM on Mondays and Wednesdays.
            </p>
        </article>
        <article class="notice-card">
            <h4 data-i18n="Walk-In Triage">Walk-In Triage</h4>
            <p data-i18n="Walk-in triage is available daily from 8:00 AM to 9:30 AM.">
                Walk-in triage is available daily from 8:00 AM to 9:30 AM.
            </p>
        </article>
        <article class="notice-card">
            <h4 data-i18n="Medication Pickup">Medication Pickup</h4>
            <p data-i18n="Please collect prescribed medication within 7 days of approval.">
                Please collect prescribed medication within 7 days of approval.
            </p>
        </article>
        <article class="notice-card">
            <h4 data-i18n="Service Improvements">Service Improvements</h4>
            <p data-i18n="We are upgrading the appointment reminder system on weekends.">
                We are upgrading the appointment reminder system on weekends.
            </p>
        </article>
    </div>
</section>

<section>
    <h3 data-i18n="Upcoming Programs">Upcoming Programs</h3>
    <div class="articles-grid">
        <article class="article-card">
            <div class="article-content">
                <h4 data-i18n="Flu Vaccination Week">Flu Vaccination Week</h4>
                <p data-i18n="Vaccination is offered every Tuesday afternoon in February.">
                    Vaccination is offered every Tuesday afternoon in February.
                </p>
                <span class="article-meta" data-i18n="Community Care">Community Care</span>
            </div>
        </article>
        <article class="article-card">
            <div class="article-content">
                <h4 data-i18n="Mental Wellness Check-In">Mental Wellness Check-In</h4>
                <p data-i18n="Book a 15-minute wellbeing chat with the clinic counselor.">
                    Book a 15-minute wellbeing chat with the clinic counselor.
                </p>
                <span class="article-meta" data-i18n="Counseling">Counseling</span>
            </div>
        </article>
        <article class="article-card">
            <div class="article-content">
                <h4 data-i18n="Student Health Week">Student Health Week</h4>
                <p data-i18n="Free BMI and blood pressure screening at the lobby.">
                    Free BMI and blood pressure screening at the lobby.
                </p>
                <span class="article-meta" data-i18n="Wellness Screening">Wellness Screening</span>
            </div>
        </article>
    </div>
</section>

<section>
    <h3 data-i18n="Need Assistance?">Need Assistance?</h3>
    <ul>
        <li data-i18n="Use the Helpdesk chat in the app or call 04-1234567 for urgent matters.">
            Use the Helpdesk chat in the app or call 04-1234567 for urgent matters.
        </li>
        <li data-i18n="Tip: Keep notifications on so you never miss appointment reminders.">
            Tip: Keep notifications on so you never miss appointment reminders.
        </li>
    </ul>
</section>
@endsection
