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
        <button type="button" class="landing-hero-slider__nav landing-hero-slider__nav--prev" aria-label="Previous slide">
            <span aria-hidden="true">&#10094;</span>
        </button>
        <button type="button" class="landing-hero-slider__nav landing-hero-slider__nav--next" aria-label="Next slide">
            <span aria-hidden="true">&#10095;</span>
        </button>
        <div class="landing-hero-slider__indicators">
            <button type="button" class="landing-hero-slider__dot is-active" data-slide-index="0" aria-label="Go to slide 1" aria-current="true"></button>
            <button type="button" class="landing-hero-slider__dot" data-slide-index="1" aria-label="Go to slide 2"></button>
            <button type="button" class="landing-hero-slider__dot" data-slide-index="2" aria-label="Go to slide 3"></button>
            <button type="button" class="landing-hero-slider__dot" data-slide-index="3" aria-label="Go to slide 4"></button>
        </div>
    </div>
</section>

<style>
    .landing-hero {
        padding: 0;
        border: 0;
        background: transparent;
        box-shadow: none;
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
    }

    .landing-hero-slider {
        position: relative;
        width: 100%;
        border: 0;
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
        height: clamp(320px, 52vw, 620px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0f172a;
    }

    .landing-hero-slider__slide img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
    }

    .landing-hero-slider__nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        width: 2.2rem;
        height: 2.2rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.7);
        background: rgba(15, 23, 42, 0.45);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 1.1rem;
        line-height: 1;
    }

    .landing-hero-slider__nav:hover {
        background: rgba(15, 23, 42, 0.72);
    }

    .landing-hero-slider__nav--prev {
        left: 0.9rem;
    }

    .landing-hero-slider__nav--next {
        right: 0.9rem;
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

    .landing-hero-slider__dot {
        width: 0.55rem;
        height: 0.55rem;
        border-radius: 999px;
        border: 1px solid rgba(15, 23, 42, 0.35);
        background: rgba(255, 255, 255, 0.55);
        padding: 0;
    }

    .landing-hero-slider__dot.is-active {
        background: #ffffff;
    }

    .program-poster-modal {
        position: fixed !important;
        inset: 0 !important;
        z-index: 1200 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: clamp(0.5rem, 1.8vw, 1rem) !important;
    }

    .program-poster-modal[hidden] {
        display: none !important;
    }

    .program-poster-modal__backdrop {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.78);
        backdrop-filter: blur(2px);
    }

    .program-poster-modal__content {
        position: relative;
        width: min(760px, 92vw);
        max-height: calc(100vh - 1rem);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border-radius: 0.85rem;
        background: #ffffff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.35);
    }

    .program-poster-modal__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.75rem 0.85rem 0.65rem;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .program-poster-modal__header h5 {
        margin: 0;
        font-size: 1rem;
    }

    .program-poster-modal__actions {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .program-poster-modal__image-wrap {
        padding: 0.75rem;
        overflow: auto;
        overscroll-behavior: contain;
        background: #f8fafc;
        display: flex;
        justify-content: center;
    }

    .program-poster-modal__image-frame {
        width: min(520px, 100%);
        max-height: calc(100vh - 11rem);
        aspect-ratio: 3 / 4;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        border-radius: 0.5rem;
        padding: 0.45rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .program-poster-modal__image-frame img {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }

    @media (max-width: 1024px) {
        .landing-hero {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 768px) {
        .landing-hero-slider__slide {
            height: auto;
            aspect-ratio: 16 / 9;
        }

        .landing-hero-slider__slide img {
            object-fit: cover;
        }

        .landing-hero-slider__nav {
            width: 1.9rem;
            height: 1.9rem;
            font-size: 0.95rem;
        }

        .landing-hero-slider__nav--prev {
            left: 0.55rem;
        }

        .landing-hero-slider__nav--next {
            right: 0.55rem;
        }

        .program-poster-modal {
            padding: 0;
        }

        .program-poster-modal__content {
            width: 100%;
            height: 100vh;
            max-height: 100vh;
            border-radius: 0;
        }

        .program-poster-modal__image-wrap {
            padding: 0.55rem;
        }

        .program-poster-modal__image-frame {
            width: min(100%, 380px);
            max-height: calc(100vh - 8.8rem);
        }
    }
</style>
 
<section>
    <h3 data-i18n="Clinic Notices and Bulletins">Clinic Notices and Bulletins</h3>
    <div class="notice-board">
        @forelse ($bulletins as $bulletin)
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
                                <div class="program-poster-modal__image-frame">
                                    <img
                                        src="{{ $posterUrl }}"
                                        alt="{{ $bulletin->title }} poster"
                                        loading="lazy"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </article>
        @empty
            <p class="notice-empty" data-i18n="No clinic bulletins available right now.">No clinic bulletins available right now.</p>
        @endforelse
    </div>
</section>

<section class="landing-downloads">
    <h3 data-i18n="Forms and Downloads">Forms and Downloads</h3>
    <div class="downloads-grid">
        @forelse ($downloadableForms as $downloadableForm)
            <article class="download-card">
                <h4>{{ $downloadableForm->title }}</h4>
                @if ($downloadableForm->description)
                    <p>{{ $downloadableForm->description }}</p>
                @endif
                <a
                    class="button-link secondary"
                    href="{{ asset($downloadableForm->file_path) }}"
                    download="{{ basename($downloadableForm->file_path) }}"
                    data-i18n="Download Form"
                >
                    Download Form
                </a>
            </article>
        @empty
            <p class="download-empty" data-i18n="No forms available for download right now.">No forms available for download right now.</p>
        @endforelse
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
            const indicators = Array.from(slider.querySelectorAll('.landing-hero-slider__dot'));
            const previousButton = slider.querySelector('.landing-hero-slider__nav--prev');
            const nextButton = slider.querySelector('.landing-hero-slider__nav--next');
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
                    indicator.setAttribute('aria-current', index === currentIndex ? 'true' : 'false');
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

            const showNextSlide = () => {
                goToSlide(currentIndex + 1);
            };

            const showPreviousSlide = () => {
                goToSlide(currentIndex - 1);
            };

            slider.addEventListener('mouseenter', () => {
                if (intervalId) {
                    window.clearInterval(intervalId);
                }
            });

            slider.addEventListener('mouseleave', () => {
                startAutoSwipe();
            });

            indicators.forEach((indicator) => {
                indicator.addEventListener('click', () => {
                    const index = Number(indicator.dataset.slideIndex);
                    if (Number.isNaN(index)) {
                        return;
                    }

                    goToSlide(index);
                    startAutoSwipe();
                });
            });

            if (previousButton) {
                previousButton.addEventListener('click', () => {
                    showPreviousSlide();
                    startAutoSwipe();
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', () => {
                    showNextSlide();
                    startAutoSwipe();
                });
            }

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
