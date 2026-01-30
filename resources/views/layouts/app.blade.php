<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>eKesihatan</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
</head>
<body>
    <a class="skip-link" href="#main-content" data-i18n="Skip to content">Skip to content</a>
    <header>
        <div class="brand">
            <h1><a href="{{ route('landing') }}">eKesihatan</a></h1>
            <span class="brand-subtitle" data-i18n="Unit Kesihatan UiTM Perlis">Unit Kesihatan UiTM Perlis</span>
        </div>
        <div class="header-actions">
            <div class="language-controls" role="group" aria-label="Language">
                <label class="font-label" for="language-select" data-i18n="Language">Language</label>
                <select id="language-select">
                    <option value="en">English</option>
                    <option value="ms">Bahasa Melayu</option>
                </select>
            </div>
            <div class="font-controls" role="group" aria-label="Font size">
                <span class="font-label" data-i18n="Font size">Font size</span>
                <button type="button" data-font-size="14">A-</button>
                <button type="button" data-font-size="16" class="active">A</button>
                <button type="button" data-font-size="18">A+</button>
            </div>
            <nav class="top-nav">
                @guest
                    <a href="{{ route('landing') }}" data-i18n="Home">Home</a>
                    <a href="{{ route('news') }}" data-i18n="Latest News">Latest News</a>
                    <a href="{{ route('login') }}" data-i18n="Login">Login</a>
                    <a href="{{ route('register') }}" data-i18n="Register">Register</a>
                @endguest
            </nav>
        </div>
    </header>
 
    <div class="app-shell">
        @auth
            @unless (request()->routeIs('landing'))
            <aside class="sidebar">
                <div class="sidebar-title" data-i18n="Navigation">Navigation</div>
                <nav class="sidebar-nav">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}">
                            <span class="icon" aria-hidden="true">🏠</span>
                            <span data-i18n="Admin Dashboard">Admin Dashboard</span>
                        </a>
                        <a href="{{ route('admin.services.index') }}">
                            <span class="icon" aria-hidden="true">🩺</span>
                            <span data-i18n="Health Services">Health Services</span>
                        </a>
                        <a href="{{ route('admin.doctors.index') }}">
                            <span class="icon" aria-hidden="true">👩‍⚕️</span>
                            <span data-i18n="Doctors">Doctors</span>
                        </a>
                        <a href="{{ route('admin.slots.index') }}">
                            <span class="icon" aria-hidden="true">🗓️</span>
                            <span data-i18n="Appointment Slots">Appointment Slots</span>
                        </a>
                        <a href="{{ route('admin.appointments.index') }}">
                            <span class="icon" aria-hidden="true">📋</span>
                            <span data-i18n="Appointments">Appointments</span>
                        </a>
                    @elseif (auth()->user()->isDoctor())
                        <a href="{{ route('dashboard') }}">
                            <span class="icon" aria-hidden="true">🏠</span>
                            <span data-i18n="Doctor Dashboard">Doctor Dashboard</span>
                        </a>
                        <a href="{{ route('doctor.appointments.index') }}">
                            <span class="icon" aria-hidden="true">📅</span>
                            <span data-i18n="Daily Appointments">Daily Appointments</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}">
                            <span class="icon" aria-hidden="true">🏠</span>
                            <span data-i18n="Patient Dashboard">Patient Dashboard</span>
                        </a>
                        <a href="{{ route('patient.services.index') }}">
                            <span class="icon" aria-hidden="true">🧾</span>
                            <span data-i18n="Health Services">Health Services</span>
                        </a>
                        <a href="{{ route('patient.appointments.create') }}">
                            <span class="icon" aria-hidden="true">➕</span>
                            <span data-i18n="Book Appointment">Book Appointment</span>
                        </a>
                        <a href="{{ route('patient.appointments.index') }}">
                            <span class="icon" aria-hidden="true">📋</span>
                            <span data-i18n="My Appointments">My Appointments</span>
                        </a>
                    @endif
 
                    <a href="{{ route('news') }}">
                        <span class="icon" aria-hidden="true">📰</span>
                        <span data-i18n="Latest News">Latest News</span>
                    </a>
                    <a href="{{ route('profile.edit') }}">
                        <span class="icon" aria-hidden="true">👤</span>
                        <span data-i18n="Profile">Profile</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="sidebar-logout">
                        @csrf
                        <button type="submit">
                            <span class="icon" aria-hidden="true">🚪</span>
                            <span data-i18n="Logout">Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>
            @endunless
        @endauth
 
        <main id="main-content" class="main-content">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
 
    <footer>
        <p data-i18n="Unit Kesihatan UiTM Perlis · eKesihatan Appointment System">Unit Kesihatan UiTM Perlis · eKesihatan Appointment System</p>
    </footer>
 
    <script>
        (function () {
            const buttons = document.querySelectorAll('[data-font-size]');
            const root = document.documentElement;
            const storageKey = 'ekesihatan-font-size';
 
            const applySize = (size) => {
                root.style.setProperty('--base-font-size', size + 'px');
                buttons.forEach((button) => {
                    const isActive = button.dataset.fontSize === size;
                    button.classList.toggle('active', isActive);
                    button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });
            };
 
            const stored = localStorage.getItem(storageKey);
            if (stored) {
                applySize(stored);
            } else {
                applySize('16');
            }
 
            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    const size = button.dataset.fontSize;
                    localStorage.setItem(storageKey, size);
                    applySize(size);
                });
            });
        })();
    </script>
 
    <script>
        (function () {
            const translations = {
                ms: {
                    'Skip to content': 'Langkau ke kandungan',
                    'Unit Kesihatan UiTM Perlis': 'Unit Kesihatan UiTM Perlis',
                    'Language': 'Bahasa',
                    'Font size': 'Saiz fon',
                    'Home': 'Laman Utama',
                    'Login': 'Log Masuk',
                    'Register': 'Daftar',
                    'Navigation': 'Navigasi',
                    'Admin Dashboard': 'Papan Pemuka Admin',
                    'Doctor Dashboard': 'Papan Pemuka Doktor',
                    'Patient Dashboard': 'Papan Pemuka Pesakit',
                    'Health Services': 'Perkhidmatan Kesihatan',
                    'Add Service': 'Tambah Perkhidmatan',
                    'Add Health Service': 'Tambah Perkhidmatan Kesihatan',
                    'Service Name': 'Nama Perkhidmatan',
                    'Duration (minutes)': 'Tempoh (minit)',
                    'Create Service': 'Cipta Perkhidmatan',
                    'Edit Health Service': 'Sunting Perkhidmatan Kesihatan',
                    'Update Service': 'Kemas Kini Perkhidmatan',
                    'Edit': 'Sunting',
                    'Delete': 'Padam',
                    'No services created.': 'Tiada perkhidmatan dicipta.',
                    'Doctors': 'Doktor',
                    'Add Doctor': 'Tambah Doktor',
                    'Edit Doctor': 'Sunting Doktor',
                    'Create Doctor': 'Cipta Doktor',
                    'Update Doctor': 'Kemas Kini Doktor',
                    'No doctors added.': 'Tiada doktor ditambah.',
                    'Temporary Password': 'Kata Laluan Sementara',
                    'Phone': 'Telefon',
                    'Specialization': 'Kepakaran',
                    'Appointment Slots': 'Slot Temu Janji',
                    'Add Slot': 'Tambah Slot',
                    'Add Appointment Slot': 'Tambah Slot Temu Janji',
                    'Edit Appointment Slot': 'Sunting Slot Temu Janji',
                    'Create Slot': 'Cipta Slot',
                    'Update Slot': 'Kemas Kini Slot',
                    'No appointment slots created.': 'Tiada slot temu janji dicipta.',
                    'Appointments': 'Temu Janji',
                    'Appointment Review': 'Semakan Temu Janji',
                    'Review': 'Semak',
                    'Action': 'Tindakan',
                    'Daily Appointments': 'Temu Janji Harian',
                    'Book Appointment': 'Tempah Temu Janji',
                    'Book New Appointment': 'Tempah Temu Janji Baharu',
                    'My Appointments': 'Temu Janji Saya',
                    'Upcoming Appointments': 'Temu Janji Akan Datang',
                    'Manage your appointments and health services.': 'Urus temu janji dan perkhidmatan kesihatan anda.',
                    'View Health Services': 'Lihat Perkhidmatan Kesihatan',
                    'Today\'s appointments for': 'Temu janji hari ini untuk',
                    'Manage services, doctors, appointment slots, and approvals.': 'Urus perkhidmatan, doktor, slot temu janji dan kelulusan.',
                    'Pending Appointments:': 'Temu Janji Menunggu:',
                    'Today\'s Appointments:': 'Temu Janji Hari Ini:',
                    'Active Services:': 'Perkhidmatan Aktif:',
                    'Doctors:': 'Doktor:',
                    'Quick Actions': 'Tindakan Pantas',
                    'Manage Health Services': 'Urus Perkhidmatan Kesihatan',
                    'Manage Doctors': 'Urus Doktor',
                    'Manage Appointment Slots': 'Urus Slot Temu Janji',
                    'Manage Appointments': 'Urus Temu Janji',
                    'View Daily Appointments': 'Lihat Temu Janji Harian',
                    'No appointments scheduled.': 'Tiada temu janji dijadualkan.',
                    'Patient History': 'Sejarah Pesakit',
                    'No appointment history.': 'Tiada sejarah temu janji.',
                    'Select Date': 'Pilih Tarikh',
                    'History': 'Sejarah',
                    'Profile': 'Profil',
                    'Logout': 'Log Keluar',
                    'Latest News': 'Berita Terkini',
                    'Latest News & Information': 'Berita dan Maklumat Terkini',
                    'Stay updated with clinic announcements, system enhancements, and health campaigns.': 'Sentiasa maklum dengan pengumuman klinik, penambahbaikan sistem, dan kempen kesihatan.',
                    'System Update': 'Kemas Kini Sistem',
                    'Faster appointment booking and rescheduling are now available across the app.': 'Tempahan dan penjadualan semula temu janji kini lebih pantas di seluruh aplikasi.',
                    'Queue Check-In Reminder': 'Peringatan Daftar Masuk Giliran',
                    'Your QR check-in screen now highlights the counter time window.': 'Skrin daftar masuk QR kini menonjolkan masa kaunter.',
                    'Document Upload Ready': 'Muat Naik Dokumen Sedia',
                    'Upload medical certificates directly after your appointment.': 'Muat naik sijil perubatan terus selepas temu janji anda.',
                    'System Updates': 'Kemas Kini Sistem',
                    'Improved Appointment Timeline': 'Garis Masa Temu Janji Dipertingkat',
                    'Track approval, queue number, and check-in status in one timeline.': 'Jejaki kelulusan, nombor giliran, dan status daftar masuk dalam satu garis masa.',
                    'Released January 2026': 'Dikeluarkan Januari 2026',
                    'Smarter Slot Availability': 'Ketersediaan Slot Lebih Pintar',
                    'View live slot capacity before booking to reduce wait time.': 'Lihat kapasiti slot secara langsung sebelum membuat tempahan untuk mengurangkan masa menunggu.',
                    'Released December 2025': 'Dikeluarkan Disember 2025',
                    'Profile Health Summary': 'Ringkasan Kesihatan Profil',
                    'Update allergies, emergency contact, and medical notes in your profile.': 'Kemas kini alahan, hubungan kecemasan, dan nota perubatan dalam profil anda.',
                    'Released November 2025': 'Dikeluarkan November 2025',
                    'Clinic Announcements': 'Pengumuman Klinik',
                    'Extended Counter Hours': 'Waktu Kaunter Dilanjutkan',
                    'Counter service is open until 5:30 PM on Mondays and Wednesdays.': 'Perkhidmatan kaunter dibuka hingga 5:30 petang pada hari Isnin dan Rabu.',
                    'Walk-In Triage': 'Triage Tanpa Temu Janji',
                    'Walk-in triage is available daily from 8:00 AM to 9:30 AM.': 'Triage tanpa temu janji tersedia setiap hari dari 8:00 pagi hingga 9:30 pagi.',
                    'Medication Pickup': 'Pengambilan Ubat',
                    'Please collect prescribed medication within 7 days of approval.': 'Sila ambil ubat yang diluluskan dalam tempoh 7 hari.',
                    'Service Improvements': 'Penambahbaikan Perkhidmatan',
                    'We are upgrading the appointment reminder system on weekends.': 'Kami menaik taraf sistem peringatan temu janji pada hujung minggu.',
                    'Upcoming Programs': 'Program Akan Datang',
                    'Flu Vaccination Week': 'Minggu Vaksinasi Selesema',
                    'Vaccination is offered every Tuesday afternoon in February.': 'Vaksinasi ditawarkan setiap petang Selasa pada bulan Februari.',
                    'Community Care': 'Penjagaan Komuniti',
                    'Mental Wellness Check-In': 'Semakan Kesejahteraan Mental',
                    'Book a 15-minute wellbeing chat with the clinic counselor.': 'Tempah sesi sembang kesejahteraan 15 minit bersama kaunselor klinik.',
                    'Counseling': 'Kaunseling',
                    'Student Health Week': 'Minggu Kesihatan Pelajar',
                    'Free BMI and blood pressure screening at the lobby.': 'Saringan BMI dan tekanan darah percuma di lobi.',
                    'Wellness Screening': 'Saringan Kesejahteraan',
                    'Need Assistance?': 'Perlukan Bantuan?',
                    'Use the Helpdesk chat in the app or call 04-1234567 for urgent matters.': 'Gunakan chat Meja Bantuan dalam aplikasi atau hubungi 04-1234567 untuk perkara segera.',
                    'Tip: Keep notifications on so you never miss appointment reminders.': 'Tip: Pastikan notifikasi diaktifkan supaya anda tidak terlepas peringatan temu janji.',
                    'Welcome to eKesihatan': 'Selamat Datang ke eKesihatan',
                    'Your health visits, organized. Book appointments, receive queue numbers, and check in with a QR code before you arrive.': 'Lawatan kesihatan anda lebih teratur. Tempah temu janji, terima nombor giliran, dan imbas QR sebelum anda tiba.',
                    'Create Patient Account': 'Daftar Akaun Pesakit',
                    'Live Slot Availability': 'Ketersediaan Slot Secara Langsung',
                    'See active doctors and open slots in one view.': 'Lihat doktor aktif dan slot tersedia dalam satu paparan.',
                    'Queue Number Ready': 'Nombor Giliran Sedia',
                    'Receive your queue number after booking.': 'Terima nombor giliran selepas tempahan.',
                    'QR Attendance': 'Kehadiran QR',
                    'Scan on arrival to confirm attendance quickly.': 'Imbas semasa tiba untuk sahkan kehadiran dengan cepat.',
                    'Clinic Flow Snapshot': 'Ringkasan Aliran Klinik',
                    'A simple, paperless flow for patients and staff.': 'Aliran ringkas tanpa kertas untuk pesakit dan staf.',
                    'Check your BMI instantly with basic inputs.': 'Semak BMI anda segera dengan input asas.',
                    'Step 1': 'Langkah 1',
                    'Step 2': 'Langkah 2',
                    'Step 3': 'Langkah 3',
                    'Choose a slot': 'Pilih slot',
                    'Receive queue number': 'Terima nombor giliran',
                    'Scan QR on arrival': 'Imbas QR semasa tiba',
                    'Clinic Notices and Bulletins': 'Notis dan Buletin Klinik',
                    'Operating Hours': 'Waktu Operasi',
                    'Monday to Thursday 8:00 AM to 5:00 PM. Friday 8:00 AM to 12:00 PM.': 'Isnin hingga Khamis 8:00 pagi hingga 5:00 petang. Jumaat 8:00 pagi hingga 12:00 tengah hari.',
                    'ID Required': 'ID Diperlukan',
                    'Please bring your student or staff ID for verification at the counter.': 'Sila bawa ID pelajar atau staf untuk pengesahan di kaunter.',
                    'Respiratory Care': 'Penjagaan Pernafasan',
                    'Masks are recommended for patients with cough, flu, or fever symptoms.': 'Pelitup muka disyorkan untuk pesakit dengan gejala batuk, selesema, atau demam.',
                    'Health Screening': 'Saringan Kesihatan',
                    'Walk-in screening is available every Tuesday morning.': 'Saringan tanpa temu janji tersedia setiap pagi Selasa.',
                    'Health Articles': 'Artikel Kesihatan',
                    'Healthy Campus Habits': 'Amalan Kampus Sihat',
                    'Simple routines to boost energy, focus, and immunity.': 'Rutin ringkas untuk meningkatkan tenaga, fokus, dan imuniti.',
                    'Clinic Bulletin': 'Buletin Klinik',
                    'Read Article': 'Baca Artikel',
                    'Understanding BMI': 'Memahami BMI',
                    'Learn how BMI helps track healthy weight goals.': 'Ketahui bagaimana BMI membantu menjejak sasaran berat badan sihat.',
                    'Health Education': 'Pendidikan Kesihatan',
                    'Stress and Sleep Tips': 'Tip Stres dan Tidur',
                    'Ways to rest better during busy study weeks.': 'Cara berehat lebih baik semasa minggu pengajian yang sibuk.',
                    'Wellbeing Guide': 'Panduan Kesejahteraan',
                    'Objectives': 'Objektif',
                    'Key Features': 'Ciri Utama',
                    'Role-based dashboards for Admin, Doctor, and Patient.': 'Papan pemuka berasaskan peranan untuk Admin, Doktor dan Pesakit.',
                    'Appointment booking with SMS confirmation and reminders.': 'Tempahan temu janji dengan pengesahan dan peringatan SMS.',
                    'QR check-in to mark attendance and reduce no-show cases.': 'Imbasan QR untuk merekod kehadiran dan mengurangkan ketidakhadiran.',
                    'BMI calculator and language toggle.': 'Kalkulator BMI dan pertukaran bahasa.',
                    'Secure storage of medical documents and certificates.': 'Penyimpanan selamat dokumen perubatan dan sijil.',
                    'Date': 'Tarikh',
                    'Time': 'Masa',
                    'Doctor': 'Doktor',
                    'Service': 'Perkhidmatan',
                    'Status': 'Status',
                    'Actions': 'Tindakan',
                    'Duration': 'Tempoh',
                    'Capacity': 'Kapasiti',
                    'Location': 'Lokasi',
                    'Start Time': 'Masa Mula',
                    'End Time': 'Masa Tamat',
                    'Active': 'Aktif',
                    'Notes': 'Nota',
                    'Notes (optional)': 'Nota (pilihan)',
                    'Slot': 'Slot',
                    'Update Appointment': 'Kemas Kini Temu Janji',
                    'Reschedule Appointment': 'Jadual Semula Temu Janji',
                    'New Appointment Slot': 'Slot Temu Janji Baharu',
                    'Update Status': 'Kemas Kini Status',
                    'Update': 'Kemas Kini',
                    'Submit Booking': 'Hantar Tempahan',
                    'Upload Medical Document': 'Muat Naik Dokumen Perubatan',
                    'Document Type': 'Jenis Dokumen',
                    'Select PDF File': 'Pilih Fail PDF',
                    'Select PDF or JPG File': 'Pilih Fail PDF atau JPG',
                    'Upload': 'Muat Naik',
                    'Medical Documents': 'Dokumen Perubatan',
                    'Upload PDF Document': 'Muat Naik Dokumen PDF',
                    'Upload Document': 'Muat Naik Dokumen',
                    'No documents uploaded.': 'Tiada dokumen dimuat naik.',
                    'Appointment': 'Temu Janji',
                    'Patient': 'Pesakit',
                    'Patient:': 'Pesakit:',
                    'Email:': 'E-mel:',
                    'Service:': 'Perkhidmatan:',
                    'Current Status:': 'Status Semasa:',
                    'Scheduled At:': 'Dijadualkan Pada:',
                    'Doctor:': 'Doktor:',
                    'Date:': 'Tarikh:',
                    'Time:': 'Masa:',
                    'Status:': 'Status:',
                    'Appointment:': 'Temu Janji:',
                    'Action': 'Tindakan',
                    'View': 'Lihat',
                    'Reschedule': 'Jadual Semula',
                    'Cancel': 'Batal',
                    'No appointments found.': 'Tiada temu janji ditemui.',
                    'BMI Calculator': 'Kalkulator BMI',
                    'Sex': 'Jantina',
                    'Male': 'Lelaki',
                    'Female': 'Perempuan',
                    'Other': 'Lain-lain',
                    'Age': 'Umur',
                    'Height (cm)': 'Tinggi (cm)',
                    'Weight (kg)': 'Berat (kg)',
                    'Calculate BMI': 'Kira BMI',
                    'Your BMI:': 'BMI Anda:',
                    'Category:': 'Kategori:',
                    'Appointment Details': 'Butiran Temu Janji',
                    'Checked in at:': 'Waktu daftar hadir:',
                    'Not checked in yet.': 'Belum daftar hadir.',
                    'Queue Number:': 'Nombor Giliran:',
                    'Queue number will be assigned when your booking is confirmed.': 'Nombor giliran akan diberikan apabila tempahan anda disahkan.',
                    'Show QR Check-In': 'Paparkan Imbasan QR',
                    'Attendance recorded.': 'Kehadiran direkodkan.',
                    'SMS Notifications': 'Notifikasi SMS',
                    'You will receive SMS confirmation and reminders 1 day and 1 hour before your appointment.': 'Anda akan menerima pengesahan SMS dan peringatan 1 hari dan 1 jam sebelum temu janji.',
                    'Medical Documents': 'Dokumen Perubatan',
                    'View PDF': 'Lihat PDF',
                    'View Document': 'Lihat Dokumen',
                    'No documents uploaded yet.': 'Tiada dokumen dimuat naik.',
                    'Check-In Successful': 'Daftar Masuk Berjaya',
                    'Your Queue Number:': 'Nombor Giliran Anda:',
                    'Checked in at:': 'Waktu daftar hadir:',
                    'SMS & Queue': 'SMS & Giliran',
                    'You will receive an SMS confirmation and your queue number once your booking is submitted.': 'Anda akan menerima pengesahan SMS dan nombor giliran selepas tempahan dihantar.',
                    'Patient Registration': 'Pendaftaran Pesakit',
                    'Full Name': 'Nama Penuh',
                    'Student ID': 'ID Pelajar',
                    'Email': 'E-mel',
                    'Phone Number': 'Nombor Telefon',
                    'Password': 'Kata Laluan',
                    'Confirm Password': 'Sahkan Kata Laluan',
                    'Update Profile': 'Kemas Kini Profil',
                    'Name': 'Nama',
                    'Staff ID': 'ID Staf',
                    'Specialization (Doctor)': 'Kepakaran (Doktor)',
                    'New Password (optional)': 'Kata Laluan Baharu (pilihan)',
                    'Save Changes': 'Simpan Perubahan',
                    'Health Services': 'Perkhidmatan Kesihatan',
                    'Description': 'Penerangan',
                    'Duration (mins)': 'Tempoh (minit)',
                    'mins': 'min',
                    'No active services.': 'Tiada perkhidmatan aktif.',
                    'QR Check-In': 'Imbasan QR',
                    'Show this QR code at the clinic to record your attendance.': 'Tunjukkan kod QR ini di klinik untuk merekod kehadiran anda.',
                    'Alternatively, open this URL on the counter device:': 'Sebagai alternatif, buka URL ini pada peranti kaunter:',
                    'Unit Kesihatan UiTM Perlis · eKesihatan Appointment System': 'Unit Kesihatan UiTM Perlis · Sistem Temu Janji eKesihatan'
                }
            };
 
            const languageSelect = document.getElementById('language-select');
            const translationCache = {};
 
            const translateText = async (text, target) => {
                if (translationCache[`${target}:${text}`]) {
                    return translationCache[`${target}:${text}`];
                }
 
                const response = await fetch('{{ route('translate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ text, target }),
                });
 
                if (!response.ok) {
                    return text;
                }
 
                const data = await response.json();
                const translated = data.translated_text || text;
                translationCache[`${target}:${text}`] = translated;
                return translated;
            };
 
            const applyLanguage = async (lang) => {
                document.documentElement.lang = lang;
                const elements = Array.from(document.querySelectorAll('[data-i18n]'));
 
                if (lang === 'en') {
                    elements.forEach((el) => {
                        el.textContent = el.getAttribute('data-i18n');
                    });
                    return;
                }
 
                await Promise.all(
                    elements.map(async (el) => {
                        const key = el.getAttribute('data-i18n');
                        const translated = translations[lang]?.[key] || await translateText(key, lang);
                        el.textContent = translated;
                    })
                );
            };
 
            const storedLang = localStorage.getItem('ekesihatan-lang') || 'en';
            languageSelect.value = storedLang;
            applyLanguage(storedLang);
 
            languageSelect.addEventListener('change', () => {
                const lang = languageSelect.value;
                localStorage.setItem('ekesihatan-lang', lang);
                applyLanguage(lang);
            });
        })();
    </script>
</body>
</html>