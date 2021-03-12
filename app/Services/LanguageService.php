<?php
namespace App\Services;
use Illuminate\Support\Facades\Facade;
/**
 * @method static initLocalization()
 * @method static getLocales()
 * @method static setLocale(string $locale)
 * @method static refreshLocale()
 * @method static getCurrentLocale()
 */
class LanguageService extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Containers\LanguageServiceContainer';
    }
}
