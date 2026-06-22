<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentRescheduledNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Appointment $appointment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $doctorName = $this->appointment->doctor?->name ?? 'Assigned Doctor';
        $serviceName = $this->appointment->service?->name ?? 'Clinic Service';
        $scheduledAt = $this->appointment->scheduled_at
            ? $this->appointment->scheduled_at->format('d M Y, h:i A')
            : '-';

        return (new MailMessage)
            ->subject('Appointment Reschedule Notice')
            ->greeting('Hello ' . ($notifiable->name ?? 'there') . ',')
            ->line('Your appointment schedule has been updated and requires your attention.')
            ->line('Service: ' . $serviceName)
            ->line('Doctor: ' . $doctorName)
            ->line('New Schedule: ' . $scheduledAt)
            ->action('Check Updated Appointment', route('patient.appointments.show', $this->appointment))
            ->line('If this time is not suitable, please contact Unit Kesihatan for assistance.');
    }
}
