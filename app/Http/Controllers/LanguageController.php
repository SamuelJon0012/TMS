<?php

namespace App\Http\Controllers;
use LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLocale($locale)
    {
        $locales = LanguageService::getLocales();
        if ($locales->where('slug', $locale)->count()){
            LanguageService::setLocale($locale);
        }
        return redirect()->back();
    }
}
