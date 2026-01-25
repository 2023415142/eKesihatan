<?php
 
namespace App\Services;
 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
 
class TranslationService
{
    public function translate(string $text, string $target): string
    {
        $apiKey = config('services.google.translate_key');
 
        if (!$apiKey) {
            Log::info('Google Translate API key missing, returning original text.');
            return $text;
        }
 
        $response = Http::asForm()->post('https://translation.googleapis.com/language/translate/v2', [
            'q' => $text,
            'target' => $target,
            'source' => 'en',
            'key' => $apiKey,
        ]);
 
        if (!$response->ok()) {
            Log::warning('Translate API failed', ['status' => $response->status(), 'body' => $response->body()]);
            return $text;
        }
 
        $translated = (string) data_get($response->json(), 'data.translations.0.translatedText', $text);
 
        return html_entity_decode($translated, ENT_QUOTES, 'UTF-8');
    }
}