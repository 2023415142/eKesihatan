@extends('layouts.app')
 
@section('content')
<section class="landing-hero">
    <div class="landing-hero-slider" id="landing-hero-slider" aria-roledescription="carousel" aria-label="eKesihatan highlights" aria-live="polite">
        <div class="landing-hero-slider__track">
            <figure class="landing-hero-slider__slide">
                <img src="{{ asset('images/intern.jpg') }}" alt="Interns at Unit Kesihatan UiTM">
            </figure>
            <figure class="landing-hero-slider__slide">
                <img src="{{ asset('images/inside.jpg') }}" alt="Inside the clinic reception area">
            </figure>
            <figure class="landing-hero-slider__slide">
                <img src="{{ asset('images/1000langkah.jpg') }}" alt="1000 langkah healthy activity event">
            </figure>
            <figure class="landing-hero-slider__slide">
                <img src="{{ asset('images/santuniKomuniti.jpg') }}" alt="Santuni komuniti health outreach session">
            </figure>
        </div>
        <div class="landing-hero-slider__indicators" aria-hidden="true">
            <span class="is-active"></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</section>

<style>
    .landing-hero {
        padding: 0;
        border: 0;
        background: transparent;
        box-shadow: none;
    }

    .landing-hero-slider {
        position: relative;
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 0;
        overflow: hidden;
        background: #0f172a;
    }

    .landing-hero-slider__track {
        display: flex;
        transition: transform 700ms ease;
        will-change: transform;
    }

    .landing-hero-slider__slide {
        margin: 0;
        min-width: 100%;
        width: 100%;
        aspect-ratio: 12 / 5;
    }

    .landing-hero-slider__slide img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .landing-hero-slider__indicators {
        position: absolute;
        left: 50%;
        bottom: 0.9rem;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        z-index: 1;
    }

    .landing-hero-slider__indicators span {
        width: 0.55rem;
        height: 0.55rem;
        border-radius: 999px;
        border: 1px solid rgba(15, 23, 42, 0.35);
        background: rgba(255, 255, 255, 0.55);
    }

    .landing-hero-slider__indicators span.is-active {
        background: #ffffff;
    }

    @media (max-width: 1024px) {
        .landing-hero {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 768px) {
        .landing-hero-slider__slide {
            aspect-ratio: 16 / 9;
        }
    }
</style>
 
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
        @if ($bulletins->isEmpty())
            @php
                $fallbackPosterPath = file_exists(public_path('images/kempen-derma-darah-poster.jpeg'))
                    ? 'images/kempen-derma-darah-poster.jpeg'
                    : 'images/kempen-derma-darah-poster.jpg';
                $fallbackModalId = 'bulletin-poster-modal-fallback';
            @endphp
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
                        class="button-link secondary js-open-bulletin-modal"
                        data-target="{{ $fallbackModalId }}"
                        aria-controls="{{ $fallbackModalId }}"
                        aria-expanded="false"
                        data-i18n="Read Program Details"
                    >
                        Read Program Details
                    </button>
                </div>
                <div id="{{ $fallbackModalId }}" class="program-poster-modal" hidden>
                    <div class="program-poster-modal__backdrop" data-poster-close="true"></div>
                    <div class="program-poster-modal__content" role="dialog" aria-modal="true" aria-labelledby="{{ $fallbackModalId }}-title">
                        <div class="program-poster-modal__header">
                            <h5 id="{{ $fallbackModalId }}-title" data-i18n="Kempen Derma Darah Poster">Kempen Derma Darah Poster</h5>
                            <div class="program-poster-modal__actions">
                                <a
                                    class="program-poster-modal__open-full"
                                    href="{{ asset($fallbackPosterPath) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    data-i18n="Open Full Poster"
                                >
                                    Open Full Poster
                                </a>
                                <button type="button" class="program-poster-modal__close js-close-bulletin-modal" aria-label="Close poster modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only" data-i18n="Close Poster">Close Poster</span>
                                </button>
                            </div>
                        </div>
                        <div class="program-poster-modal__image-wrap">
                            <img
                                src="{{ asset($fallbackPosterPath) }}"
                                alt="Poster Kempen Derma Darah Perdana UiTM"
                                loading="lazy"
                            >
                        </div>
                    </div>
                </div>
            </article>
        @else
            @foreach ($bulletins as $bulletin)
                @php
                    $modalId = 'bulletin-poster-modal-' . $bulletin->id;
                    $posterUrl = $bulletin->poster_path ? asset($bulletin->poster_path) : null;
                @endphp
                <article class="notice-card notice-card--program" id="bulletin-{{ $bulletin->id }}">
                    <h4>{{ $bulletin->title }}</h4>
                    @if ($bulletin->summary)
                        <p>{{ $bulletin->summary }}</p>
                    @endif

                    @if ($bulletin->event_date || $bulletin->event_time || $bulletin->location)
                        <ul class="bulletin-meta">
                            @if ($bulletin->event_date)
                                <li><strong data-i18n="Date:">Date:</strong> {{ $bulletin->event_date->format('d M Y (l)') }}</li>
                            @endif
                            @if ($bulletin->event_time)
                                <li><strong data-i18n="Time:">Time:</strong> {{ $bulletin->event_time }}</li>
                            @endif
                            @if ($bulletin->location)
                                <li><strong data-i18n="Location:">Location:</strong> {{ $bulletin->location }}</li>
                            @endif
                        </ul>
                    @endif

                    @if ($bulletin->details)
                        <p>{{ $bulletin->details }}</p>
                    @endif

                    @if ($posterUrl)
                        <div class="bulletin-actions">
                            <button
                                type="button"
                                class="button-link secondary js-open-bulletin-modal"
                                data-target="{{ $modalId }}"
                                aria-controls="{{ $modalId }}"
                                aria-expanded="false"
                                data-i18n="Read Program Details"
                            >
                                Read Program Details
                            </button>
                        </div>

                        <div id="{{ $modalId }}" class="program-poster-modal" hidden>
                            <div class="program-poster-modal__backdrop" data-poster-close="true"></div>
                            <div class="program-poster-modal__content" role="dialog" aria-modal="true" aria-labelledby="{{ $modalId }}-title">
                                <div class="program-poster-modal__header">
                                    <h5 id="{{ $modalId }}-title">{{ $bulletin->title }}</h5>
                                    <div class="program-poster-modal__actions">
                                        <a
                                            class="program-poster-modal__open-full"
                                            href="{{ $posterUrl }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            data-i18n="Open Full Poster"
                                        >
                                            Open Full Poster
                                        </a>
                                        <button type="button" class="program-poster-modal__close js-close-bulletin-modal" aria-label="Close poster modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only" data-i18n="Close Poster">Close Poster</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="program-poster-modal__image-wrap">
                                    <img
                                        src="{{ $posterUrl }}"
                                        alt="{{ $bulletin->title }} poster"
                                        loading="lazy"
                                    >
                                </div>
                            </div>
                        </div>
                    @endif
                </article>
            @endforeach
        @endif
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
        const initializeSlider = () => {
            const slider = document.getElementById('landing-hero-slider');
            if (!slider || slider.dataset.sliderReady === 'true') {
                return;
            }

            const track = slider.querySelector('.landing-hero-slider__track');
            if (!track) {
                return;
            }

            const slides = Array.from(track.querySelectorAll('.landing-hero-slider__slide'));
            const indicators = Array.from(slider.querySelectorAll('.landing-hero-slider__indicators span'));
            if (slides.length < 2) {
                return;
            }

            slider.dataset.sliderReady = 'true';

            // Apply core layout styles in JS as a fallback
            // when browser cache serves stale CSS.
            slider.style.overflow = 'hidden';
            track.style.display = 'flex';
            track.style.transition = 'transform 700ms ease';
            slides.forEach((slide) => {
                slide.style.minWidth = '100%';
            });

            const intervalMs = 4500;
            let currentIndex = 0;
            let intervalId = null;

            const updateIndicators = () => {
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('is-active', index === currentIndex);
                });
            };

            const goToSlide = (index) => {
                currentIndex = (index + slides.length) % slides.length;
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                updateIndicators();
            };

            const startAutoSwipe = () => {
                if (intervalId) {
                    window.clearInterval(intervalId);
                }

                intervalId = window.setInterval(() => {
                    goToSlide(currentIndex + 1);
                }, intervalMs);
            };

            slider.addEventListener('mouseenter', () => {
                if (intervalId) {
                    window.clearInterval(intervalId);
                }
            });

            slider.addEventListener('mouseleave', () => {
                startAutoSwipe();
            });

            goToSlide(0);
            startAutoSwipe();
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeSlider, { once: true });
        } else {
            initializeSlider();
        }
    })();
</script>

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
        const openButtons = Array.from(document.querySelectorAll('.js-open-bulletin-modal'));
        if (!openButtons.length) {
            return;
        }

        let activeModal = null;
        let activeTrigger = null;

        const getFocusableElements = (modal) => {
            const dialogContent = modal.querySelector('.program-poster-modal__content');
            if (!dialogContent) {
                return [];
            }

            return Array.from(
                dialogContent.querySelectorAll(
                    'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'
                )
            );
        };

        const closeModal = (modal) => {
            modal.setAttribute('hidden', 'hidden');
            document.body.classList.remove('poster-modal-open');

            if (activeTrigger) {
                activeTrigger.setAttribute('aria-expanded', 'false');
                activeTrigger.focus();
            }

            activeModal = null;
            activeTrigger = null;
        };

        const openModal = (modal, triggerButton) => {
            if (activeModal && activeModal !== modal) {
                closeModal(activeModal);
            }

            if (modal.hasAttribute('hidden')) {
                modal.removeAttribute('hidden');
                triggerButton.setAttribute('aria-expanded', 'true');
                document.body.classList.add('poster-modal-open');
                activeModal = modal;
                activeTrigger = triggerButton;
                const closeButton = modal.querySelector('.js-close-bulletin-modal');
                if (closeButton instanceof HTMLElement) {
                    closeButton.focus();
                }
            }
        };

        openButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.dataset.target;
                if (!targetId) {
                    return;
                }

                const modal = document.getElementById(targetId);
                if (!modal) {
                    return;
                }

                openModal(modal, button);
            });
        });

        const closeButtons = Array.from(document.querySelectorAll('.js-close-bulletin-modal'));
        closeButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const modal = button.closest('.program-poster-modal');
                if (modal) {
                    closeModal(modal);
                }
            });
        });

        const modalBackdrops = Array.from(document.querySelectorAll('.program-poster-modal__backdrop'));
        modalBackdrops.forEach((backdrop) => {
            backdrop.addEventListener('click', () => {
                const modal = backdrop.closest('.program-poster-modal');
                if (modal) {
                    closeModal(modal);
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (!activeModal) {
                return;
            }

            if (event.key === 'Tab') {
                const focusableElements = getFocusableElements(activeModal);
                if (!focusableElements.length) {
                    event.preventDefault();
                    return;
                }

                const first = focusableElements[0];
                const last = focusableElements[focusableElements.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                    return;
                }

                if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                    return;
                }
            }

            if (event.key === 'Escape') {
                closeModal(activeModal);
            }
        });
    })();
</script>
@endsection
