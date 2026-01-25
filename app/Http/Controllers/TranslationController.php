<?php
 
namespace App\Http\Controllers;
 
use App\Services\TranslationService;
use Illuminate\Http\Request;
 
class TranslationController extends Controller
{
    public function translate(Request $request, TranslationService $translationService)
    {
        $data = $request->validate([
            'text' => ['required', 'string', 'max:2000'],
            'target' => ['required', 'in:ms,zh'],
        ]);
 
        $translated = $translationService->translate($data['text'], $data['target']);
 
        return response()->json([
            'translated_text' => $translated,
        ]);
    }
}