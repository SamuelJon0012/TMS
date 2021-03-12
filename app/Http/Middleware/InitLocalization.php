<?php
namespace App\Http\Middleware;
use App\Services\LanguageService;
use Closure;
use Illuminate\Support\Facades\Route;
class InitLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        LanguageService::initLocalization();
        return $next($request);
    }
}
