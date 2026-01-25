<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\AppointmentSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
 
class AppointmentSlotController extends Controller
{
    public function index()
    {
        return view('admin.slots.index', [
            'slots' => AppointmentSlot::with('doctor')->orderBy('slot_date')->orderBy('start_time')->get(),
        ]);
    }
 
    public function create()
    {
        return view('admin.slots.create', [
            'doctors' => User::where('role', User::ROLE_DOCTOR)->orderBy('name')->get(),
        ]);
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_DOCTOR)],
            'slot_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);
 
        $data['is_active'] = $request->boolean('is_active');
 
        AppointmentSlot::create($data);
 
        return redirect()->route('admin.slots.index')->with('status', 'Appointment slot created.');
    }
 
    public function edit(AppointmentSlot $slot)
    {
        return view('admin.slots.edit', [
            'slot' => $slot,
            'doctors' => User::where('role', User::ROLE_DOCTOR)->orderBy('name')->get(),
        ]);
    }
 
    public function update(Request $request, AppointmentSlot $slot)
    {
        $data = $request->validate([
            'doctor_id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_DOCTOR)],
            'slot_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);
 
        $data['is_active'] = $request->boolean('is_active');
 
        $slot->update($data);
 
        return redirect()->route('admin.slots.index')->with('status', 'Appointment slot updated.');
    }
 
    public function destroy(AppointmentSlot $slot)
    {
        $slot->delete();
 
        return redirect()->route('admin.slots.index')->with('status', 'Appointment slot removed.');
    }
}
