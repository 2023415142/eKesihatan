<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        return view('staff.patients.index', [
            'patients' => User::where('role', User::ROLE_PATIENT)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(Request $request, User $patient)
    {
        if (!$patient->isPatient()) {
            abort(404);
        }

        return view('staff.patients.show', [
            'patient' => $patient,
        ]);
    }
}
