<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use App\Notifications\AppointmentBookedNotification;
use App\Notifications\AppointmentRescheduledNotification;
use App\Notifications\RegistrationSuccessfulNotification;
use Illuminate\Support\Facades\Log;

class EmailNotificationService
{
    public function sendRegistrationSuccess(User $user): void
    {
        if (!$this->canSendTo($user)) {
            return;
        }

        try {
            $user->notify(new RegistrationSuccessfulNotification($user));
        } catch (\Throwable $exception) {
            Log::warning('Unable to send registration success email.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function sendBookingSuccess(Appointment $appointment): void
    {
        $appointment->loadMissing(['patient', 'doctor', 'service']);
        $patient = $appointment->patient;

        if (!$patient || !$this->canSendTo($patient)) {
            return;
        }

        try {
            $patient->notify(new AppointmentBookedNotification($appointment));
        } catch (\Throwable $exception) {
            Log::warning('Unable to send appointment booking email.', [
                'appointment_id' => $appointment->id,
                'patient_id' => $patient->id,
                'email' => $patient->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function sendRescheduleNotice(Appointment $appointment): void
    {
        $appointment->loadMissing(['patient', 'doctor', 'service']);
        $patient = $appointment->patient;

        if (!$patient || !$this->canSendTo($patient)) {
            return;
        }

        try {
            $patient->notify(new AppointmentRescheduledNotification($appointment));
        } catch (\Throwable $exception) {
            Log::warning('Unable to send appointment reschedule email.', [
                'appointment_id' => $appointment->id,
                'patient_id' => $patient->id,
                'email' => $patient->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function canSendTo(User $user): bool
    {
        return is_string($user->email) && trim($user->email) !== '';
    }
}
