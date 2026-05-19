<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\MedicalDocument;
 
class User extends Authenticatable
{
    use HasFactory, Notifiable;
 
    public const ROLE_ADMIN = 'admin';
    public const ROLE_DOCTOR = 'doctor';
    public const ROLE_PATIENT = 'patient';
 
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
        'blood_type',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'allergies',
        'staff_id',
        'phone_number',
        'specialization',
    ];
 
    protected $hidden = ['password','remember_token'];
 
    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime','password' => 'hashed'];
    }
 
    public function isAdmin(): bool { return $this->role === self::ROLE_ADMIN; }
    public function isDoctor(): bool { return $this->role === self::ROLE_DOCTOR; }
    public function isPatient(): bool { return $this->role === self::ROLE_PATIENT; }
 
    public function appointmentSlots() { return $this->hasMany(AppointmentSlot::class, 'doctor_id'); }
    public function appointmentsAsPatient() { return $this->hasMany(Appointment::class, 'patient_id'); }
    public function appointmentsAsDoctor() { return $this->hasMany(Appointment::class, 'doctor_id'); }
    public function uploadedDocuments() { return $this->hasMany(MedicalDocument::class, 'uploaded_by'); }
}