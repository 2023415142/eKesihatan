<?php
 
namespace Database\Seeders;
 
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\HealthService;
use App\Models\QueueTicket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
 
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Hasya Shamsul',
            'email' => 'hasya@ekesihatan.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'phone_number' => '016-678 9012',
            'staff_id' => 'ADM-001',
        ]);

        $doctorUsers = collect([
            [
                'name' => 'Dr. Aisyah Arifin',
                'email' => 'aisyah55@ekesihatan.com',
                'staff_id' => 'DOC-001',
                'phone_number' => '012-345 6789',
                'specialization' => 'General Practitioner',
            ],
            [
                'name' => 'Dr. Khalid Muhsin',
                'email' => 'khalidm@ekesihatan.com',
                'staff_id' => 'DOC-002',
                'phone_number' => '013-456 7890',
                'specialization' => 'Family Medicine',
            ],
            [
                'name' => 'Dr. Hanis Baba',
                'email' => 'hanisb@ekesihatan.com',
                'staff_id' => 'DOC-003',
                'phone_number' => '014-555 2211',
                'specialization' => 'General Practitioner',
            ],
        ])->map(function (array $doctor) {
            return User::create([
                'name' => $doctor['name'],
                'email' => $doctor['email'],
                'password' => Hash::make('password'),
                'role' => User::ROLE_DOCTOR,
                'phone_number' => $doctor['phone_number'],
                'specialization' => $doctor['specialization'],
                'staff_id' => $doctor['staff_id'],
            ]);
        });

        $patients = collect([
            [
                'name' => 'Patient Example',
                'email' => 'patient@ekesihatan.test',
                'student_id' => 'STU-12345',
                'phone_number' => '0123456791',
            ],
            [
                'name' => 'Nurul Safiah',
                'email' => 'nurul@ekesihatan.com',
                'student_id' => 'STU-56789',
                'phone_number' => '0123456792',
            ],
            [
                'name' => 'Amir Nazri',
                'email' => 'amir@ekesihatan.com',
                'student_id' => 'STU-24680',
                'phone_number' => '0123456793',
            ],
        ])->map(function (array $patient) {
            return User::create([
                'name' => $patient['name'],
                'email' => $patient['email'],
                'password' => Hash::make('password'),
                'role' => User::ROLE_PATIENT,
                'phone_number' => $patient['phone_number'],
                'student_id' => $patient['student_id'],
            ]);
        });

        $services = collect([
            [
                'name' => 'General Consultation',
                'description' => 'Basic medical consultation and assessment.',
                'duration_minutes' => 20,
            ],
            [
                'name' => 'Dental Check-up',
                'description' => 'Routine dental assessment and oral health advice.',
                'duration_minutes' => 30,
            ],
            [
                'name' => 'Mental Health Counseling',
                'description' => 'Confidential counseling with clinic staff.',
                'duration_minutes' => 45,
            ],
        ])->map(function (array $service) {
            return HealthService::create([
                'name' => $service['name'],
                'description' => $service['description'],
                'duration_minutes' => $service['duration_minutes'],
                'is_active' => true,
            ]);
        });

        $slotRows = collect([
            [
                'doctor' => $doctorUsers[0],
                'date' => now()->addDays(1)->toDateString(),
                'start' => '08:30',
                'end' => '09:00',
            ],
            [
                'doctor' => $doctorUsers[0],
                'date' => now()->addDays(1)->toDateString(),
                'start' => '09:10',
                'end' => '09:40',
            ],
            [
                'doctor' => $doctorUsers[1],
                'date' => now()->addDays(2)->toDateString(),
                'start' => '10:00',
                'end' => '10:30',
            ],
            [
                'doctor' => $doctorUsers[1],
                'date' => now()->addDays(2)->toDateString(),
                'start' => '10:40',
                'end' => '11:10',
            ],
            [
                'doctor' => $doctorUsers[2],
                'date' => now()->addDays(3)->toDateString(),
                'start' => '14:00',
                'end' => '14:30',
            ],
            [
                'doctor' => $doctorUsers[2],
                'date' => now()->addDays(3)->toDateString(),
                'start' => '15:00',
                'end' => '15:30',
            ],
        ])->map(function (array $slot) {
            return AppointmentSlot::create([
                'doctor_id' => $slot['doctor']->id,
                'slot_date' => $slot['date'],
                'start_time' => $slot['start'],
                'end_time' => $slot['end'],
                'capacity' => 5,
                'location' => 'Unit Kesihatan UiTM Perlis',
                'is_active' => true,
            ]);
        });

        $queueCounters = [];

        collect([
            [
                'patient' => $patients[0],
                'doctor' => $doctorUsers[0],
                'slot' => $slotRows[0],
                'service' => $services[0],
                'status' => 'approved',
            ],
            [
                'patient' => $patients[1],
                'doctor' => $doctorUsers[0],
                'slot' => $slotRows[1],
                'service' => $services[1],
                'status' => 'pending',
            ],
            [
                'patient' => $patients[2],
                'doctor' => $doctorUsers[1],
                'slot' => $slotRows[2],
                'service' => $services[0],
                'status' => 'approved',
            ],
            [
                'patient' => $patients[0],
                'doctor' => $doctorUsers[1],
                'slot' => $slotRows[3],
                'service' => $services[2],
                'status' => 'pending',
            ],
            [
                'patient' => $patients[1],
                'doctor' => $doctorUsers[2],
                'slot' => $slotRows[4],
                'service' => $services[1],
                'status' => 'approved',
            ],
            [
                'patient' => $patients[2],
                'doctor' => $doctorUsers[2],
                'slot' => $slotRows[5],
                'service' => $services[2],
                'status' => 'pending',
            ],
        ])->each(function (array $data, int $index) use (&$queueCounters) {
            $slot = $data['slot'];
            $scheduledAt = $slot->slot_date->format('Y-m-d') . ' ' . $slot->start_time;

            $appointment = Appointment::create([
                'patient_id' => $data['patient']->id,
                'doctor_id' => $data['doctor']->id,
                'health_service_id' => $data['service']->id,
                'appointment_slot_id' => $slot->id,
                'scheduled_at' => $scheduledAt,
                'status' => $data['status'],
                'check_in_token' => (string) Str::uuid(),
                'approved_at' => $data['status'] === 'approved' ? now() : null,
                'checked_in_at' => $index === 0 ? now() : null,
            ]);

            $issuedOn = $slot->slot_date->format('Y-m-d');
            $queueCounters[$issuedOn] = ($queueCounters[$issuedOn] ?? 0) + 1;

            QueueTicket::create([
                'appointment_id' => $appointment->id,
                'issued_on' => $issuedOn,
                'number' => $queueCounters[$issuedOn],
            ]);

            $appointment->update(['queue_number' => $queueCounters[$issuedOn]]);
        });
    }
}