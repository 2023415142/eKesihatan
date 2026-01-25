<?php
 
namespace App\Http\Controllers\Patient;
 
use App\Http\Controllers\Controller;
use App\Models\HealthService;
 
class ServiceController extends Controller
{
    public function index()
    {
        return view('patient.services.index', [
            'services' => HealthService::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
