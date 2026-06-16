@extends('layouts.app')
 
@section('content')
<section class="landing-hero">
    <div class="landing-hero__content">
        <h2 data-i18n="Welcome to eKesihatan">Welcome to eKesihatan</h2>
        <p data-i18n="Your health visits, organized. Book appointments, receive queue numbers, and check in with a QR code before you arrive.">
            Your health visits, organized. Book appointments, receive queue numbers, and check in with a QR code before you arrive.
        </p>
    </div>
 
    <div class="landing-hero__visual">
        <div class="infographic-card">
            <h3 data-i18n="Clinic Flow Snapshot">Clinic Flow Snapshot</h3>
            <p data-i18n="A simple, paperless flow for patients and staff.">A simple, paperless flow for patients and staff.</p>
            <svg viewBox="0 0 360 120" role="img" aria-labelledby="flow-title">
                <title id="flow-title">Clinic flow infographic</title>
                <rect x="0" y="0" width="360" height="120" rx="12" fill="#f8fafc"></rect>
                <circle cx="50" cy="60" r="18" fill="#1d4ed8"></circle>
                <circle cx="180" cy="60" r="18" fill="#0f766e"></circle>
                <circle cx="310" cy="60" r="18" fill="#b45309"></circle>
                <line x1="68" y1="60" x2="162" y2="60" stroke="#94a3b8" stroke-width="4"></line>
                <line x1="198" y1="60" x2="292" y2="60" stroke="#94a3b8" stroke-width="4"></line>
                <text x="50" y="100" text-anchor="middle" font-size="12" fill="#1b1f24">Book</text>
                <text x="180" y="100" text-anchor="middle" font-size="12" fill="#1b1f24">Queue</text>
                <text x="310" y="100" text-anchor="middle" font-size="12" fill="#1b1f24">Check-in</text>
            </svg>
            <div class="infographic-steps">
                <div class="infographic-step">
                    <span data-i18n="Step 1">Step 1</span>
                    <strong data-i18n="Choose a slot">Choose a slot</strong>
                </div>
                <div class="infographic-step">
                    <span data-i18n="Step 2">Step 2</span>
                    <strong data-i18n="Receive queue number">Receive queue number</strong>
                </div>
                <div class="infographic-step">
                    <span data-i18n="Step 3">Step 3</span>
                    <strong data-i18n="Scan QR on arrival">Scan QR on arrival</strong>
                </div>
            </div>
        </div>
    </div>
</section>
 
<section class="bmi-card landing-bmi">
    <h3 data-i18n="BMI Calculator">BMI Calculator</h3>
    <p data-i18n="Check your BMI instantly with basic inputs.">Check your BMI instantly with basic inputs.</p>
    <form id="landing-bmi-form" class="bmi-form">
        <div class="bmi-grid">
            <div>
                <label for="landing-bmi-sex" data-i18n="Sex">Sex</label>
                <select id="landing-bmi-sex" name="sex" required>
                    <option value="male" data-i18n="Male">Male</option>
                    <option value="female" data-i18n="Female">Female</option>
                    <option value="other" data-i18n="Other">Other</option>
                </select>
            </div>
            <div>
                <label for="landing-bmi-age" data-i18n="Age">Age</label>
                <input id="landing-bmi-age" name="age" type="number" min="1" max="120" required>
            </div>
            <div>
                <label for="landing-bmi-height" data-i18n="Height (cm)">Height (cm)</label>
                <input id="landing-bmi-height" name="height_cm" type="number" step="0.1" min="50" max="250" required>
            </div>
            <div>
                <label for="landing-bmi-weight" data-i18n="Weight (kg)">Weight (kg)</label>
                <input id="landing-bmi-weight" name="weight_kg" type="number" step="0.1" min="10" max="300" required>
            </div>
        </div>
        <button type="submit" data-i18n="Calculate BMI">Calculate BMI</button>
    </form>
    <div id="landing-bmi-result" class="bmi-result" hidden>
        <p><strong data-i18n="Your BMI:">Your BMI:</strong> <span id="landing-bmi-value">-</span></p>
        <p><strong data-i18n="Category:">Category:</strong> <span id="landing-bmi-category">-</span></p>
    </div>
</section>
 
<section>
    <h3 data-i18n="Clinic Notices and Bulletins">Clinic Notices and Bulletins</h3>
    <div class="notice-board">
        <article class="notice-card">
            <h4 data-i18n="Operating Hours">Operating Hours</h4>
            <p data-i18n="Monday to Thursday 8:00 AM to 5:00 PM. Friday 8:00 AM to 12:00 PM.">
                Monday to Thursday 8:00 AM to 5:00 PM. Friday 8:00 AM to 12:00 PM.
            </p>
        </article>
        <article class="notice-card notice-card--program" id="program-kempen-derma-darah">
            <h4 data-i18n="Kempen Derma Darah Perdana">Kempen Derma Darah Perdana</h4>
            <p data-i18n="Join Unit Kesihatan UiTM Arau for a blood donation campaign and campus health engagement activities.">
                Join Unit Kesihatan UiTM Arau for a blood donation campaign and campus health engagement activities.
            </p>
            <ul class="bulletin-meta">
                <li><strong data-i18n="Date:">Date:</strong> 16 Jun 2026 (Tuesday)</li>
                <li><strong data-i18n="Time:">Time:</strong> 10:00 AM - 5:00 PM</li>
                <li><strong data-i18n="Location:">Location:</strong> Dewan Agung Tuanku Canselor (DATC), UiTM Shah Alam</li>
            </ul>
            <p data-i18n="Activities include health exhibitions, health talks, and UiTM product sales. Open to UiTM community members and public participants who meet donation requirements.">
                Activities include health exhibitions, health talks, and UiTM product sales. Open to UiTM community members and public participants who meet donation requirements.
            </p>
            <div class="bulletin-actions">
                <button
                    type="button"
                    class="button-link secondary"
                    id="read-program-details-button"
                    aria-controls="program-poster-panel"
                    aria-expanded="false"
                    data-i18n="Read Program Details"
                >
                    Read Program Details
                </button>
            </div>
            <div id="program-poster-panel" class="program-poster" hidden>
                @php
                    $programPosterPath = file_exists(public_path('images/kempen-derma-darah-poster.jpeg'))
                        ? 'images/kempen-derma-darah-poster.jpeg'
                        : 'images/kempen-derma-darah-poster.jpg';
                @endphp
                <img
                    src="{{ asset($programPosterPath) }}"
                    alt="Poster Kempen Derma Darah Perdana UiTM"
                    loading="lazy"
                >
            </div>
        </article>
    </div>
</section>
 
<section>
    <h3 data-i18n="Health Articles">Health Articles</h3>
    <div class="articles-grid">
        <article class="article-card">
            <div class="article-media" aria-hidden="true">
                <svg viewBox="0 0 240 120" role="presentation">
                    <rect width="240" height="120" rx="12" fill="#e0f2fe"></rect>
                    <circle cx="60" cy="60" r="22" fill="#1d4ed8"></circle>
                    <rect x="100" y="45" width="110" height="12" fill="#94a3b8"></rect>
                    <rect x="100" y="65" width="80" height="10" fill="#cbd5f5"></rect>
                </svg>
            </div>
            <div class="article-content">
                <h4 data-i18n="Healthy Campus Habits">Healthy Campus Habits</h4>
                <p data-i18n="Simple routines to boost energy, focus, and immunity.">Simple routines to boost energy, focus, and immunity.</p>
                <span class="article-meta" data-i18n="Clinic Bulletin">Clinic Bulletin</span>
                <a class="card-link" href="#" data-i18n="Read Article">Read Article</a>
            </div>
        </article>
        <article class="article-card">
            <div class="article-media" aria-hidden="true">
                <svg viewBox="0 0 240 120" role="presentation">
                    <rect width="240" height="120" rx="12" fill="#f0fdf4"></rect>
                    <rect x="20" y="30" width="80" height="60" rx="10" fill="#0f766e"></rect>
                    <rect x="120" y="40" width="90" height="12" fill="#94a3b8"></rect>
                    <rect x="120" y="60" width="70" height="10" fill="#bbf7d0"></rect>
                </svg>
            </div>
            <div class="article-content">
                <h4 data-i18n="Understanding BMI">Understanding BMI</h4>
                <p data-i18n="Learn how BMI helps track healthy weight goals.">Learn how BMI helps track healthy weight goals.</p>
                <span class="article-meta" data-i18n="Health Education">Health Education</span>
                <a class="card-link" href="#" data-i18n="Read Article">Read Article</a>
            </div>
        </article>
        <article class="article-card">
            <div class="article-media" aria-hidden="true">
                <svg viewBox="0 0 240 120" role="presentation">
                    <rect width="240" height="120" rx="12" fill="#fff7ed"></rect>
                    <circle cx="50" cy="60" r="20" fill="#b45309"></circle>
                    <rect x="90" y="38" width="120" height="12" fill="#94a3b8"></rect>
                    <rect x="90" y="60" width="90" height="10" fill="#fed7aa"></rect>
                </svg>
            </div>
            <div class="article-content">
                <h4 data-i18n="Stress and Sleep Tips">Stress and Sleep Tips</h4>
                <p data-i18n="Ways to rest better during busy study weeks.">Ways to rest better during busy study weeks.</p>
                <span class="article-meta" data-i18n="Wellbeing Guide">Wellbeing Guide</span>
                <a class="card-link" href="https://blog.ohiohealth.com/college-101-getting-enough-sleep/" target="_blank" rel="noopener noreferrer" data-i18n="Read Article">Read Article</a>
            </div>
        </article>
    </div>
</section>

<section class="landing-footer" aria-labelledby="landing-footer-title">
    <div class="landing-footer__top">
        <div class="landing-footer__brand">
            <h3 id="landing-footer-title" data-i18n="Need Help Before Your Visit?">Need Help Before Your Visit?</h3>
            <p data-i18n="Find clinic notices, appointment booking access, and health guidance in one trusted portal.">
                Find clinic notices, appointment booking access, and health guidance in one trusted portal.
            </p>
        </div>
        <a class="button-link secondary landing-footer__cta" href="{{ route('register') }}" data-i18n="Create Patient Account">
            Create Patient Account
        </a>
    </div>

    <div class="landing-footer__grid">
        <article class="landing-footer__column">
            <h4 data-i18n="Clinic Support">Clinic Support</h4>
            <ul class="landing-footer__list">
                <li data-i18n="Operating Hours">Operating Hours</li>
                <li data-i18n="Monday to Thursday 8:00 AM to 5:00 PM. Friday 8:00 AM to 12:00 PM.">
                    Monday to Thursday 8:00 AM to 5:00 PM. Friday 8:00 AM to 12:00 PM.
                </li>
                <li data-i18n="Please bring your student or staff ID for verification at the counter.">
                    Please bring your student or staff ID for verification at the counter.
                </li>
                <li>
                    <span data-i18n="Phone (Unit Kesihatan):">Phone (Unit Kesihatan):</span>
                    <a href="tel:+6049881234">+60 4-988 1234</a>
                </li>
                <li>
                    <span data-i18n="Email (Unit Kesihatan):">Email (Unit Kesihatan):</span>
                    <a href="mailto:unitkesihatan@uitm.edu.my">unitkesihatan@uitm.edu.my</a>
                </li>
            </ul>
        </article>
        <article class="landing-footer__column">
            <h4 data-i18n="Digital Services">Digital Services</h4>
            <ul class="landing-footer__list">
                <li data-i18n="Book Appointment">Book Appointment</li>
                <li data-i18n="Queue Number Ready">Queue Number Ready</li>
                <li data-i18n="QR Attendance">QR Attendance</li>
            </ul>
        </article>
    </div>

    <div class="landing-footer__bottom">
        <p data-i18n="Designed for students and staff healthcare access.">Designed for students and staff healthcare access.</p>
    </div>
</section>
 
<script>
    (function () {
        const form = document.getElementById('landing-bmi-form');
        if (!form) {
            return;
        }
 
        const result = document.getElementById('landing-bmi-result');
        const bmiValue = document.getElementById('landing-bmi-value');
        const bmiCategory = document.getElementById('landing-bmi-category');
        const heightInput = document.getElementById('landing-bmi-height');
        const weightInput = document.getElementById('landing-bmi-weight');
 
        const getCategory = (bmi) => {
            if (bmi < 18.5) {
                return 'Underweight';
            }
            if (bmi < 25) {
                return 'Normal';
            }
            if (bmi < 30) {
                return 'Overweight';
            }
            return 'Obese';
        };
 
        form.addEventListener('submit', (event) => {
            event.preventDefault();
 
            const heightCm = parseFloat(heightInput.value);
            const weightKg = parseFloat(weightInput.value);
 
            if (!heightCm || !weightKg) {
                return;
            }
 
            const bmi = weightKg / Math.pow(heightCm / 100, 2);
            const rounded = Math.round(bmi * 10) / 10;
 
            bmiValue.textContent = rounded.toFixed(1);
            bmiCategory.textContent = getCategory(rounded);
            result.hidden = false;
        });
    })();
</script>

<script>
    (function () {
        const readButton = document.getElementById('read-program-details-button');
        const posterPanel = document.getElementById('program-poster-panel');

        if (!readButton || !posterPanel) {
            return;
        }

        readButton.addEventListener('click', () => {
            const shouldShow = posterPanel.hasAttribute('hidden');

            if (shouldShow) {
                posterPanel.removeAttribute('hidden');
                readButton.setAttribute('aria-expanded', 'true');
                posterPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            posterPanel.setAttribute('hidden', 'hidden');
            readButton.setAttribute('aria-expanded', 'false');
        });
    })();
</script>
@endsection
