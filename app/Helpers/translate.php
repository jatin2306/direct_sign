<?php

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

function translate($text, $targetLocale = null)
{
    if (!$text) {
        return $text;
    }

    // Get the current locale from session or fallback to default locale
    $targetLocale = $targetLocale ?? session('locale', config('app.locale'));

    // Caching translations to reduce API calls
    return Cache::remember("translation_{$targetLocale}_" . md5($text), now()->addHours(12), function () use ($text, $targetLocale) {
        try {
            return GoogleTranslate::trans($text, $targetLocale);
        } catch (\Exception $e) {
            return $text; // Return original text if API fails
        }
    });
}

