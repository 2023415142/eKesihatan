<?php
 
namespace App\Http\Controllers;
 
use App\Models\Appointment;
use App\Models\HealthService;
use App\Models\User;
use Illuminate\Http\Request;
 
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
 
        if ($user->isAdmin()) {
            return view('dashboard.admin', [
                'pendingAppointments' => Appointment::where('status', 'pending')->count(),
                'todayAppointments' => Appointment::whereDate('scheduled_at', now()->toDateString())->count(),
                'servicesCount' => HealthService::count(),
                'doctorsCount' => User::where('role', User::ROLE_DOCTOR)->count(),
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
