<?php
 
namespace App\Http\Controllers;
 
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
 
class LandingController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('bulletins')) {
            return view('landing', [
                'bulletins' => collect(),
            ]);
        }

        return view('landing', [
            'bulletins' => Bulletin::query()
                ->where('is_published', true)
                ->orderByDesc('event_date')
                ->latest()
                ->get(),
        ]);
    }
}