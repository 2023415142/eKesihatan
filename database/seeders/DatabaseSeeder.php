
<?php
 
//namespace Database\Seeders;
 
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\HealthService;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
 
    public function run(): void
    {
        $admin = User::create([
            'name' => 'eKesihatan Admin',
            'email' => 'admin@ekesihatan.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'phone_number' => '0123456789',
        ]);
 
        $doctor = User::create([
            'name' => 'Dr. Aisyah',
            'email' => 'doctor@ekesihatan.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DOCTOR,
            'phone_number' => '0123456790',
            'specialization' => 'General Practitioner',
            'staff_id' => 'DOC-001',
        ]);
 
        $patient = User::create([
            'name' => 'Patient Example',
            'email' => 'patient@ekesihatan.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_PATIENT,
            'phone_number' => '0123456791',
            'student_id' => 'STU-12345',
        ]);
 
        $service = HealthService::create([
            'name' => 'General Consultation',
            'description' => 'Basic medical consultation and assessment.',
            'duration_minutes' => 20,
            'is_active' => true,
        ]);
 
        $slot = AppointmentSlot::create([
            'doctor_id' => $doctor->id,
            'slot_date' => now()->addDay()->toDateString(),
            'start_time' => '09:00',
            'end_time' => '09:30',
            'capacity' => 5,
            'location' => 'Unit Kesihatan UiTM Perlis',
            'is_active' => true,
        ]);
 
        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'health_service_id' => $service->id,
            'appointment_slot_id' => $slot->id,
            'scheduled_at' => $slot->slot_date->format('Y-m-d') . ' ' . $slot->start_time,
            'status' => 'approved',
            'check_in_token' => (string) \Illuminate\Support\Str::uuid(),
            'approved_at' => now(),
        ]);
    }
}