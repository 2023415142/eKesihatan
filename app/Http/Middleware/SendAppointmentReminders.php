<?php
 
namespace App\Console\Commands;
 
use App\Models\Appointment;
use App\Services\SmsService;
use Illuminate\Console\Command;
 
class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send SMS reminders for upcoming appointments.';
 
    public function handle(SmsService $smsService): int
    {
        $this->sendWindowReminder($smsService, 'day', now()->addDay()->startOfHour(), now()->addDay()->endOfHour());
        $this->sendWindowReminder($smsService, 'hour', now()->addHour()->startOfMinute(), now()->addHour()->endOfMinute());
 
        $this->info('Appointment reminders processed.');
 
        return self::SUCCESS;
    }
 
    private function sendWindowReminder(SmsService $smsService, string $window, $start, $end): void
    {
        $column = $window === 'day' ? 'reminder_day_sent_at' : 'reminder_hour_sent_at';
 
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereIn('status', ['approved', 'pending'])
            ->whereNull($column)
            ->whereBetween('scheduled_at', [$start, $end])
            ->get();
 
        foreach ($appointments as $appointment) {
            $smsService->sendReminder($appointment->patient, $appointment, $window === 'day' ? '1 day' : '1 hour');
            $appointment->update([$column => now()]);
        }
    }
}
