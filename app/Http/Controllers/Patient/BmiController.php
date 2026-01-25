<?php
 
namespace App\Http\Controllers\Patient;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class BmiController extends Controller
{
    public function show()
    {
        return view('patient.bmi');
    }
 
    public function calculate(Request $request)
    {
        $data = $request->validate([
            'sex' => ['required', 'in:male,female,other'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'height_cm' => ['required', 'numeric', 'min:50', 'max:250'],
            'weight_kg' => ['required', 'numeric', 'min:20', 'max:300'],
        ]);
 
        $heightM = $data['height_cm'] / 100;
        $bmi = $data['weight_kg'] / ($heightM * $heightM);
        $bmiRounded = round($bmi, 1);
 
        $category = match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 25 => 'Normal',
            $bmi < 30 => 'Overweight',
            default => 'Obese',
        };
 
        $payload = [
            'bmi' => $bmiRounded,
            'category' => $category,
            'sex' => $data['sex'],
            'age' => $data['age'],
            'height_cm' => $data['height_cm'],
            'weight_kg' => $data['weight_kg'],
        ];
 
        if ($request->input('redirect') === 'dashboard') {
            return redirect()->route('dashboard')->with('bmi_result', $payload);
        }
 
        return view('patient.bmi', $payload);
    }
}