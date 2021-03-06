<?php
namespace App\Services\Containers;
use App\User;
class LanguageServiceContainer
{
    private $locales;
    private $SESSION_KEY = 'locale';
    public function getLocales(){
        if ($this->locales === null) $this->locales = collect(config('languages.locales'));
        return $this->locales;
    }
    public function getCurrentLocale(){
        return $this->getLocales()->where('slug', app()->getLocale())->first();
    }
    public function getOtherLocales(){
        $locale = app()->getLocale();
        return $this->getLocales()->reject(function($item) use ($locale) {
            return $item['slug'] == $locale;
        });
    }
    public function setLocale($locale) {
        $this->setUserLocale($locale);
        $this->setSessionLocale($locale);
        return true;
    }
    private function getSessionLocale() {
        return session($this->SESSION_KEY, null);
    }
    private function getDefaultLocale(){
        return config('languages.default', 'en');
    }
    private function setUserLocale($locale){
        if (auth()->check()) {
            User::where('id', auth()->user()->id)->update(['locale' => $locale]);
            return true;
        }
        return false;
    }
    private function setSessionLocale($locale){
        session([$this->SESSION_KEY=>$locale]);
        session()->save();
        return true;
    }
    public function initLocalization(){
        $locales = $this->getLocales()->pluck('slug')->toArray();
        $session_locale = $this->getSessionLocale();
        $locale = null;
        if (auth()->check()) {
            $locale = auth()->user()->locale;
        }
        if ($locale && in_array($locale, $locales)) {
            if ($locale!=$session_locale) $this->setSessionLocale($locale);
        }
        elseif ($session_locale && in_array($session_locale, $locales)) {
            $locale = $session_locale;
            $this->setUserLocale($locale);
        }
        else {
            $locale = $this->getDefaultLocale();
            $this->setLocale($locale);
        }
        app()->setLocale($locale);
        return true;
    }
    public function refreshLocale(){
        $this->setLocale(app()->getLocale());
    }
}
