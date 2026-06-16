<?php
 
namespace App\Http\Controllers;
 
use App\Models\Bulletin;
use Illuminate\Http\Request;
 
class LandingController extends Controller
{
    public function index(Request $request)
    {
        return view('landing', [
            'bulletins' => Bulletin::query()
                ->where('is_published', true)
                ->orderByDesc('event_date')
                ->latest()
                ->get(),
        ]);
    }
}