<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\HealthService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AppointmentScheduler
{
    public function findBestSlot(HealthService $service, Carbon $preferredDate, ?int $doctorId = null): ?AppointmentSlot
    {
        $preferredDate = $preferredDate->copy()->startOfDay();

        $slotsQuery = AppointmentSlot::query()
            ->where('is_active', true)
            ->whereDate('slot_date', '>=', $preferredDate->toDateString())
            ->orderBy('slot_date')
            ->orderBy('start_time');

        if ($doctorId) {
            $slotsQuery->where('doctor_id', $doctorId);
        }

        $slots = $slotsQuery->get();
        if ($slots->isEmpty()) {
            return null;
        }

        $slotIds = $slots->pluck('id');
        $activeCounts = Appointment::whereIn('appointment_slot_id', $slotIds)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->selectRaw('appointment_slot_id, count(*) as total')
            ->groupBy('appointment_slot_id')
            ->pluck('total', 'appointment_slot_id');

        $workloadMap = $this->buildWorkloadMap($slots, $preferredDate);

        $best = null;
        $bestStart = null;
        $bestWorkload = null;

        foreach ($slots as $slot) {
            $start = Carbon::parse($slot->slot_date->format('Y-m-d') . ' ' . $slot->start_time);
            $end = Carbon::parse($slot->slot_date->format('Y-m-d') . ' ' . $slot->end_time);

            if ($end->lessThanOrEqualTo($start)) {
                continue;
            }

            $slotDuration = $start->diffInMinutes($end);
            if ($service->duration_minutes && $slotDuration < $service->duration_minutes) {
                continue;
            }

            if ($start->isPast()) {
                continue;
            }

            $activeCount = (int) ($activeCounts[$slot->id] ?? 0);
            if ($activeCount >= $slot->capacity) {
                continue;
            }

            $dayKey = $slot->slot_date->format('Y-m-d');
            $workloadKey = $slot->doctor_id . '|' . $dayKey;
            $workload = (int) ($workloadMap[$workloadKey] ?? 0);

            if (!$best) {
                $best = $slot;
                $bestStart = $start;
                $bestWorkload = $workload;
                continue;
            }

            if ($start->lt($bestStart)) {
                $best = $slot;
                $bestStart = $start;
                $bestWorkload = $workload;
                continue;
            }

            if ($start->equalTo($bestStart) && $workload < $bestWorkload) {
                $best = $slot;
                $bestWorkload = $workload;
            }
        }

        return $best;
    }

    private function buildWorkloadMap(Collection $slots, Carbon $preferredDate): Collection
    {
        $doctorIds = $slots->pluck('doctor_id')->unique();

        return Appointment::whereIn('doctor_id', $doctorIds)
            ->whereDate('scheduled_at', '>=', $preferredDate->toDateString())
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->selectRaw('doctor_id, DATE(scheduled_at) as day, count(*) as total')
            ->groupBy('doctor_id', 'day')
            ->get()
            ->mapWithKeys(function ($row) {
                return [$row->doctor_id . '|' . $row->day => $row->total];
            });
    }
}
