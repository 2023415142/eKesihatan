<?php
 
namespace App\Http\Controllers;
 
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use App\Models\HealthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
 
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
 
        if ($user->isAdmin()) {
            $calendarDays = Collection::times(7, function ($index) {
                return now()->startOfDay()->addDays($index - 1);
            });

            $calendarStart = $calendarDays->first();
            $calendarEnd = $calendarDays->last();

            $calendarSlots = AppointmentSlot::with('doctor')
                ->whereDate('slot_date', '>=', $calendarStart->toDateString())
                ->whereDate('slot_date', '<=', $calendarEnd->toDateString())
                ->orderBy('slot_date')
                ->orderBy('start_time')
                ->get();

            $slotMap = $calendarSlots->groupBy(function ($slot) {
                return $slot->doctor_id . '|' . $slot->slot_date->format('Y-m-d');
            });

            return view('dashboard.admin', [
                'pendingAppointments' => Appointment::where('status', 'pending')->count(),
                'todayAppointments' => Appointment::whereDate('scheduled_at', now()->toDateString())->count(),
                'servicesCount' => HealthService::count(),
                'doctorsCount' => User::where('role', User::ROLE_DOCTOR)->count(),
                'calendarDays' => $calendarDays,
                'calendarDoctors' => User::where('role', User::ROLE_DOCTOR)->orderBy('name')->get(),
                'slotMap' => $slotMap,
            ]);
        }
 
        if ($user->isDoctor()) {
            $todayAppointments = Appointment::with(['patient', 'service'])
                ->where('doctor_id', $user->id)
                ->whereDate('scheduled_at', now()->toDateString())
                ->orderBy('scheduled_at')
                ->get();
 
            return view('dashboard.doctor', [
                'appointments' => $todayAppointments,
            ]);
        }
 
        $upcomingAppointments = Appointment::with(['doctor', 'service'])
            ->where('patient_id', $user->id)
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->get();
 
        return view('dashboard.patient', [
            'appointments' => $upcomingAppointments,
        ]);
    }
}