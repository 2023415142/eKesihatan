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
<body id="top">
    <a class="skip-link" href="#main-content" data-i18n="Skip to content">Skip to content</a>
    <header>
        <div class="brand">
            <h1><a href="{{ route('landing') }}">eKesihatan</a></h1>
            <span class="brand-subtitle" data-i18n="Unit Kesihatan UiTM Perlis">Unit Kesihatan UiTM Perlis</span>
        </div>
        <div class="header-actions">
            <div class="header-controls">
                <div class="font-controls" role="group" aria-label="Font size">
                    <span class="font-label" data-i18n="Font size">Font size</span>
                    <button type="button" data-font-size="14">A-</button>
                    <button type="button" data-font-size="16" class="active">A</button>
                    <button type="button" data-font-size="18">A+</button>
                </div>
                <div class="language-controls" role="group" aria-label="Language">
                    <label class="font-label" for="language-select" data-i18n="Language">Language</label>
                    <select id="language-select">
                        <option value="en">English</option>
                        <option value="ms">Bahasa Melayu</option>
                    </select>
                </div>
            </div>
            <nav class="top-nav">
                @guest
                    <a href="{{ route('landing') }}" data-i18n="Home">Home</a>
                    <a href="{{ route('login') }}" data-i18n="Login">Login</a>
                    <a href="{{ route('register') }}" data-i18n="Register">Register</a>
                @endguest
            </nav>
        </div>
    </header>
 
    <div class="app-shell">
        @auth
            @unless (request()->routeIs('landing', 'login', 'register'))
            <aside class="sidebar">
                <div class="sidebar-title" data-i18n="Navigation">Navigation</div>
                <nav class="sidebar-nav">
                    <div class="sidebar-menu">
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
                            <a href="{{ route('admin.bulletins.index') }}">
                                <span class="icon" aria-hidden="true">📣</span>
                                <span data-i18n="Clinic Bulletins">Clinic Bulletins</span>
                            </a>
                            <a href="{{ route('admin.forms.index') }}">
                                <span class="icon" aria-hidden="true">📄</span>
                                <span data-i18n="Forms & Downloads">Forms & Downloads</span>
                            </a>
                            <a href="{{ route('staff.patients.index') }}">
                                <span class="icon" aria-hidden="true">🧑‍🦽</span>
                                <span data-i18n="Patient Directory">Patient Directory</span>
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
                            <a href="{{ route('staff.patients.index') }}">
                                <span class="icon" aria-hidden="true">🧑‍🦽</span>
                                <span data-i18n="Patient Directory">Patient Directory</span>
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

                        <a href="{{ route('profile.edit') }}">
                            <span class="icon" aria-hidden="true">👤</span>
                            <span data-i18n="Profile">Profile</span>
                        </a>
                    </div>
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
 
    <footer class="uitm-footer" id="site-footer">
        <div class="uitm-footer__top">
            <div class="uitm-footer__inner">
                <div class="uitm-footer__column" aria-labelledby="uitm-footer-tender">
                    <h3 id="uitm-footer-tender">IKLAN SEBUTHARGA RASMI/TENDER</h3>
                    <ul class="uitm-footer__news">
                        <li>
                            <time datetime="2026-06-16">16 June 2026</time>
                            <a href="https://perlis.uitm.edu.my/index.php/component/content/article/333-perkhidmatan-pemotongan-rumput-dan-pembersihan-kawasan-di-universiti-teknologi-mara-cawangan-perlis-kampus-arau-bagi-tempoh-enam-6-bulan?catid=48&amp;Itemid=209" target="_blank" rel="noopener noreferrer">
                                Perkhidmatan Pemotongan Rumput Dan Pembersihan Kawasan Di Universiti Teknologi MARA Cawangan Perlis Kampus Arau Bagi Tempoh Enam (6) Bulan.
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="uitm-footer__column" aria-labelledby="uitm-footer-student-info">
                    <h3 id="uitm-footer-student-info">INFORMASI PELAJAR</h3>
                    <ul class="uitm-footer__news">
                        <li>
                            <time datetime="2026-01-18">18 January 2026</time>
                            <a href="https://perlis.uitm.edu.my/index.php/component/content/article/298-jadual-waktu-peperiksaan-akhir-julai-2025?catid=47&amp;Itemid=209" target="_blank" rel="noopener noreferrer">
                                Maklumat Peperiksaan Khas Mac 2026 (MyExamHub)
                            </a>
                        </li>
                        <li>
                            <time datetime="2025-09-18">18 September 2025</time>
                            <a href="https://perlis.uitm.edu.my/index.php/component/content/article/305-maklumat-peperiksaan-khas?catid=47&amp;Itemid=209" target="_blank" rel="noopener noreferrer">
                                Maklumat Peperiksaan Khas September 2025
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="uitm-footer__column" aria-labelledby="uitm-footer-quick-links">
                    <h3 id="uitm-footer-quick-links">QUICK LINKS</h3>
                    <ul class="uitm-footer__links">
                        <li><a href="https://hea.uitm.edu.my/v4/index.php/calendars/academic-calendar" target="_blank" rel="noopener noreferrer">Academic Calendar</a></li>
                        <li><a href="https://pengambilan.uitm.edu.my/kalendar-pengambilan" target="_blank" rel="noopener noreferrer">Intake Calendar</a></li>
                        <li><a href="https://simsweb.uitm.edu.my/sportal_app/graduat/" target="_blank" rel="noopener noreferrer">Graduate Quick Search</a></li>
                        <li><a href="https://news.uitm.edu.my/" target="_blank" rel="noopener noreferrer">News</a></li>
                        <li><a href="https://uitmholdings.com/" target="_blank" rel="noopener noreferrer">UiTM Holding</a></li>
                        <li><a href="https://hoteluitm.com/" target="_blank" rel="noopener noreferrer">Hotel UiTM</a></li>
                        <li><a href="https://www.facebook.com/uitmfclions/" target="_blank" rel="noopener noreferrer">UiTM FC</a></li>
                        <li><a href="https://aduan.uitm.edu.my" target="_blank" rel="noopener noreferrer">e-Aduan</a></li>
                        <li><a href="https://www.uitm.edu.my/index.php/en/frequently-asked-questions" target="_blank" rel="noopener noreferrer">FAQ</a></li>
                        <li><a href="https://wifi.uitm.edu.my/wifi/" target="_blank" rel="noopener noreferrer">UiTM WiFi</a></li>
                    </ul>
                </div>

                <div class="uitm-footer__column" aria-labelledby="uitm-footer-contact">
                    <h3 id="uitm-footer-contact">CONTACT US</h3>
                    <div class="uitm-footer__contact-block">
                        <p class="uitm-footer__org">Universiti Teknologi MARA</p>
                        <p class="uitm-footer__org">Cawangan Perlis, Kampus Arau,</p>
                        <p>02600 Arau, Perlis.</p>
                    </div>
                    <ul class="uitm-footer__contact-list">
                        <li><a href="tel:+6049882000">+604-9882000</a></li>
                        <li><a href="tel:+6049882019">+604-9882019</a></li>
                        <li><a href="mailto:korporatperlis@uitm.edu.my">korporatperlis@uitm.edu.my</a></li>
                    </ul>
                    <div class="uitm-footer__socials">
                        <a href="https://www.facebook.com/Uitm-Cawangan-Perlis-541555815901744" target="_blank" rel="noopener noreferrer" aria-label="UiTM Perlis Facebook">f</a>
                        <a href="https://www.google.com/maps/place/UiTM+Cawangan+Perlis+Kampus+Arau/@6.4456154,100.2727978,17z/data=!3m1!4b1!4m5!3m4!1s0x304ca293e55f5bb9:0x5d96f84b4708cc7!8m2!3d6.4456101!4d100.2749865?hl=en-US" target="_blank" rel="noopener noreferrer" aria-label="UiTM Perlis location on Google Maps">G</a>
                        <a href="https://www.waze.com/en-GB/livemap/directions/malaysia/perlis/arau/uitm-cawangan-perlis-kampus-arau?dir_first=routing_only&amp;navigate=yes&amp;place=ChIJuVtf5ZOiTDARx4xwtIRv2QU&amp;utm_expid=.z332TkT-TdGeMi_l_4XUWA.1&amp;utm_referrer=" target="_blank" rel="noopener noreferrer" aria-label="UiTM Perlis location on Waze">W</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="uitm-footer__bottom">
            <div class="uitm-footer__inner uitm-footer__inner--bottom">
                <p>© COPYRIGHT UiTM CAWANGAN PERLIS 2026. ALL RIGHTS RESERVED.</p>
                <nav class="uitm-footer__policy-links" aria-label="Footer policy links">
                    <a href="https://www.uitm.edu.my/index.php/en/disclaimer-copyright" target="_blank" rel="noopener noreferrer">DISCLAIMER &amp; COPYRIGHT</a>
                    <span>|</span>
                    <a href="https://www.uitm.edu.my/index.php/en/privacy-statement" target="_blank" rel="noopener noreferrer">PRIVACY STATEMENT</a>
                    <span>|</span>
                    <a href="https://ppii.uitm.edu.my/images/pekeliling/universiti/Dasar/DasarKeselamatanICTv2.pdf" target="_blank" rel="noopener noreferrer">ICT SECURITY POLICY</a>
                </nav>
                <a class="uitm-footer__to-top" href="#top" aria-label="Back to top">↑</a>
            </div>
        </div>
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
                    'Role': 'Peranan',
                    'Admin': 'Admin',
                    'Navigation': 'Navigasi',
                    'Admin Dashboard': 'Papan Pemuka Admin',
                    'Doctor Dashboard': 'Papan Pemuka Doktor',
                    'Patient Dashboard': 'Papan Pemuka Pesakit',
                    'Patient Profile': 'Profil Pesakit',
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
                    'Patient Directory': 'Direktori Pesakit',
                    'View patient demographic and emergency details.': 'Lihat butiran demografi dan kecemasan pesakit.',
                    'Search patients': 'Cari pesakit',
                    'Search by name or student ID': 'Cari mengikut nama atau ID pelajar',
                    'Search': 'Cari',
                    'Reset': 'Reset',
                    'View Details': 'Lihat Butiran',
                    'Patient Details': 'Butiran Pesakit',
                    'Emergency information for clinical use.': 'Maklumat kecemasan untuk kegunaan klinikal.',
                    'Back to directory': 'Kembali ke direktori',
                    'No patients found.': 'Tiada pesakit ditemui.',
                    'Emergency Contact': 'Kontak Kecemasan',
                    'Emergency Contact Name': 'Nama Kontak Kecemasan',
                    'Emergency Contact Phone': 'Telefon Kontak Kecemasan',
                    'Emergency Contact Relationship': 'Hubungan Kontak Kecemasan',
                    'Blood Type': 'Jenis Darah',
                    'Select Blood Type': 'Pilih Jenis Darah',
                    'Allergies or Medical Notes': 'Alergi atau Nota Perubatan',
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
                    'Clinic Bulletins': 'Buletin Klinik',
                    'Forms & Downloads': 'Borang & Muat Turun',
                    'Appointment Review': 'Semakan Temu Janji',
                    'Review': 'Semak',
                    'Action': 'Tindakan',
                    'Daily Appointments': 'Temu Janji Harian',
                    'Book Appointment': 'Tempah Temu Janji',
                    'Book New Appointment': 'Tempah Temu Janji Baharu',
                    'My Appointments': 'Temu Janji Saya',
                    'Preferred Doctor (optional)': 'Doktor Pilihan (pilihan)',
                    'Any available doctor': 'Mana-mana doktor tersedia',
                    'Preferred Date': 'Tarikh Pilihan',
                    'Auto-assignment:': 'Auto-penjadualan:',
                    'The system will pick the earliest available slot on or after your preferred date while balancing doctor workload.': 'Sistem akan memilih slot terawal pada atau selepas tarikh pilihan anda sambil mengimbangi beban doktor.',
                    'Upcoming Appointments': 'Temu Janji Akan Datang',
                    'Next Appointment': 'Temu Janji Seterusnya',
                    'Assigned Doctor': 'Doktor Ditugaskan',
                    'Appointment Calendar': 'Kalendar Temu Janji',
                    'General Information': 'Maklumat Umum',
                    'Registration Date': 'Tarikh Pendaftaran',
                    'Anamnesis': 'Anamnesis',
                    'Medical Files': 'Fail Perubatan',
                    'Upcoming Visits': 'Lawatan Akan Datang',
                    'Past Visits': 'Lawatan Lepas',
                    'Campus Health Reminder': 'Peringatan Kesihatan Kampus',
                    'Bring your student or staff ID for verification at the clinic.': 'Bawa ID pelajar atau staf untuk pengesahan di klinik.',
                    'Arrival Guidance': 'Panduan Ketibaan',
                    'Arrive 10 minutes early to complete check-in and QR scan.': 'Tiba 10 minit awal untuk lengkapkan daftar masuk dan imbasan QR.',
                    'Wellness Tip': 'Tip Kesihatan',
                    'Stay hydrated and rest well during exam periods.': 'Kekal terhidrat dan rehat secukupnya semasa musim peperiksaan.',
                    'Manage your appointments and health services.': 'Urus temu janji dan perkhidmatan kesihatan anda.',
                    'View Health Services': 'Lihat Perkhidmatan Kesihatan',
                    'Today\'s appointments for': 'Temu janji hari ini untuk',
                    'Today': 'Hari Ini',
                    'Manage services, doctors, appointment slots, and approvals.': 'Urus perkhidmatan, doktor, slot temu janji dan kelulusan.',
                    'University Health Operations Overview': 'Ringkasan Operasi Kesihatan Universiti',
                    'Administrator': 'Pentadbir',
                    'Operations Summary': 'Ringkasan Operasi',
                    'Pending Appointments:': 'Temu Janji Menunggu:',
                    'Today\'s Appointments:': 'Temu Janji Hari Ini:',
                    'Active Services:': 'Perkhidmatan Aktif:',
                    'Doctors:': 'Doktor:',
                    'Quick Actions': 'Tindakan Pantas',
                    'Manage Health Services': 'Urus Perkhidmatan Kesihatan',
                    'Manage Doctors': 'Urus Doktor',
                    'Manage Appointment Slots': 'Urus Slot Temu Janji',
                    'Manage Appointments': 'Urus Temu Janji',
                    'Doctor Availability Calendar': 'Kalendar Ketersediaan Doktor',
                    'Review weekly slot coverage and spot leave or off-campus duties.': 'Semak liputan slot mingguan dan kenal pasti cuti atau tugas luar kampus.',
                    'No slots = Unavailable': 'Tiada slot = Tidak tersedia',
                    'No slots': 'Tiada slot',
                    'Unavailable': 'Tidak tersedia',
                    'slots': 'slot',
                    'View Daily Appointments': 'Lihat Temu Janji Harian',
                    'Daily Schedule': 'Jadual Harian',
                    'No appointments scheduled.': 'Tiada temu janji dijadualkan.',
                    'Completed': 'Selesai',
                    'No-show': 'Tidak hadir',
                    'Today\'s Summary': 'Ringkasan Hari Ini',
                    'Clinic Notes': 'Catatan Klinik',
                    'Clinic Focus': 'Fokus Klinik',
                    'Verify student or staff IDs before each consultation.': 'Sahkan ID pelajar atau staf sebelum setiap konsultasi.',
                    'Documentation': 'Dokumentasi',
                    'Upload medical certificates and notes after each visit.': 'Muat naik sijil perubatan dan nota selepas setiap lawatan.',
                    'Queue Management': 'Pengurusan Giliran',
                    'Mark no-shows promptly to keep queues accurate.': 'Tandakan tidak hadir dengan segera untuk memastikan giliran tepat.',
                    'Patient History': 'Sejarah Pesakit',
                    'No appointment history.': 'Tiada sejarah temu janji.',
                    'Select Date': 'Pilih Tarikh',
                    'History': 'Sejarah',
                    'Profile': 'Profil',
                    'Logout': 'Log Keluar',
                    'Welcome to eKesihatan': 'Selamat Datang ke eKesihatan',
                    'Your health visits, organized. Book appointments, receive queue numbers, and check in with a QR code before you arrive.': 'Lawatan kesihatan anda lebih teratur. Tempah temu janji, terima nombor giliran, dan imbas QR sebelum anda tiba.',
                    'Need Help Before Your Visit?': 'Perlu bantuan sebelum lawatan anda?',
                    'Find clinic notices, appointment booking access, and health guidance in one trusted portal.': 'Dapatkan notis klinik, akses tempahan temu janji, dan panduan kesihatan dalam satu portal yang dipercayai.',
                    'Create Patient Account': 'Daftar Akaun Pesakit',
                    'Quick Access': 'Akses Pantas',
                    'Clinic Support': 'Sokongan Klinik',
                    'Digital Services': 'Perkhidmatan Digital',
                    'Phone (Unit Kesihatan):': 'Telefon (Unit Kesihatan):',
                    'Email (Unit Kesihatan):': 'E-mel (Unit Kesihatan):',
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
                    'No clinic bulletins available right now.': 'Tiada notis atau buletin klinik buat masa ini.',
                    'Operating Hours': 'Waktu Operasi',
                    'Monday to Thursday 8:00 AM to 5:00 PM. Friday 8:00 AM to 12:00 PM.': 'Isnin hingga Khamis 8:00 pagi hingga 5:00 petang. Jumaat 8:00 pagi hingga 12:00 tengah hari.',
                    'ID Required': 'ID Diperlukan',
                    'Please bring your student or staff ID for verification at the counter.': 'Sila bawa ID pelajar atau staf untuk pengesahan di kaunter.',
                    'Respiratory Care': 'Penjagaan Pernafasan',
                    'Masks are recommended for patients with cough, flu, or fever symptoms.': 'Pelitup muka disyorkan untuk pesakit dengan gejala batuk, selesema, atau demam.',
                    'Health Screening': 'Saringan Kesihatan',
                    'Walk-in screening is available every Tuesday morning.': 'Saringan tanpa temu janji tersedia setiap pagi Selasa.',
                    'Kempen Derma Darah Perdana': 'Kempen Derma Darah Perdana',
                    'Kempen Derma Darah Poster': 'Poster Kempen Derma Darah',
                    'Join Unit Kesihatan UiTM Arau for a blood donation campaign and campus health engagement activities.': 'Sertai Unit Kesihatan UiTM Arau untuk kempen derma darah dan aktiviti penglibatan kesihatan kampus.',
                    'Read Program Details': 'Baca Butiran Program',
                    'View Poster': 'Lihat Poster',
                    'Close Poster': 'Tutup Poster',
                    'Open Full Poster': 'Buka Poster Penuh',
                    'Add Bulletin': 'Tambah Buletin',
                    'Edit Bulletin': 'Sunting Buletin',
                    'Bulletin Title': 'Tajuk Buletin',
                    'Summary': 'Ringkasan',
                    'Program Details': 'Butiran Program',
                    'Event Date': 'Tarikh Program',
                    'Event Time': 'Masa Program',
                    'Poster Image (JPG, JPEG, PNG)': 'Imej Poster (JPG, JPEG, PNG)',
                    'Current Poster': 'Poster Semasa',
                    'Remove current poster': 'Buang poster semasa',
                    'Publish on Landing Page': 'Paparkan di Laman Utama',
                    'Save Bulletin': 'Simpan Buletin',
                    'Update Bulletin': 'Kemas Kini Buletin',
                    'No bulletins created.': 'Tiada buletin dicipta.',
                    'Add Form': 'Tambah Borang',
                    'Edit Form': 'Sunting Borang',
                    'Form Title': 'Tajuk Borang',
                    'Display Order': 'Turutan Paparan',
                    'Form File (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX)': 'Fail Borang (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX)',
                    'Current File': 'Fail Semasa',
                    'Replace current file': 'Ganti fail semasa',
                    'Upload a new file when replacing the current one.': 'Muat naik fail baharu apabila menggantikan fail semasa.',
                    'Upload a new file to replace the current one.': 'Muat naik fail baharu untuk menggantikan fail semasa.',
                    'Publish for Download': 'Paparkan untuk Muat Turun',
                    'Save Form': 'Simpan Borang',
                    'Update Form': 'Kemas Kini Borang',
                    'No forms created.': 'Tiada borang dicipta.',
                    'Open File': 'Buka Fail',
                    'Forms and Downloads': 'Borang dan Muat Turun',
                    'Connect With Us': 'Hubungi Kami',
                    'Stay connected with Unit Kesihatan UiTM Perlis on social media.': 'Kekal berhubung dengan Unit Kesihatan UiTM Perlis melalui media sosial.',
                    'Explore More!': 'Terokai Lagi!',
                    'Keep updated with us on our social media.': 'Kekal berhubung dengan kami di media sosial kami.',
                    'Facebook': 'Facebook',
                    'Instagram': 'Instagram',
                    'Tiktok': 'Tiktok',
                    'Visit Page': 'Lawati Halaman',
                    'Download Form': 'Muat Turun Borang',
                    'No forms available for download right now.': 'Tiada borang untuk dimuat turun buat masa ini.',
                    'No': 'No',
                    'Document Name': 'Nama Dokumen',
                    'Format': 'Format',
                    'Size': 'Saiz',
                    'Not Available': 'Tidak Tersedia',
                    'Forms table is missing. Run php artisan migrate first.': 'Jadual borang belum wujud. Jalankan php artisan migrate dahulu.',
                    'Published': 'Diterbitkan',
                    'Draft': 'Draf',
                    'Activities include health exhibitions, health talks, and UiTM product sales. Open to UiTM community members and public participants who meet donation requirements.': 'Aktiviti merangkumi pameran kesihatan, ceramah kesihatan, dan jualan produk UiTM. Terbuka kepada warga UiTM dan orang awam yang memenuhi syarat pendermaan.',
                    'View Bulletin': 'Lihat Buletin',
                    'Register for Program': 'Daftar Program',
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
                    'Title': 'Tajuk',
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
                    'Unit Kesihatan UiTM Perlis · eKesihatan Appointment System': 'Unit Kesihatan UiTM Perlis · Sistem Temu Janji eKesihatan',
                    'Designed for students and staff healthcare access.': 'Direka untuk akses kesihatan pelajar dan staf.'
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