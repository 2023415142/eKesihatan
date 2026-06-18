<?php
 
namespace App\Http\Controllers;
 
use App\Models\Bulletin;
use App\Models\DownloadableForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
 
class LandingController extends Controller
{
    public function index(Request $request)
    {
        return view('landing', [
            'bulletins' => Schema::hasTable('bulletins')
                ? Bulletin::query()
                    ->where('is_published', true)
                    ->orderByDesc('event_date')
                    ->latest()
                    ->get()
                : collect(),
            'downloadableForms' => Schema::hasTable('downloadable_forms')
                ? DownloadableForm::query()
                    ->where('is_published', true)
                    ->whereNotNull('file_path')
                    ->orderBy('sort_order')
                    ->latest()
                    ->get()
                : collect(),
        ]);
    }
}