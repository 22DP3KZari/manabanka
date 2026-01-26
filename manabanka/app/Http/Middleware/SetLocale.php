<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, fallback to config default
        if ($request->hasSession()) {
            $sessionLocale = $request->session()->get('locale');
            
            if ($sessionLocale && in_array($sessionLocale, ['en', 'lv'])) {
                $locale = $sessionLocale;
            } else {
                $locale = config('app.locale');
            }
        } else {
            $locale = config('app.locale');
        }

        // Set the application locale
        App::setLocale($locale);
        
        // Store in request attributes for debugging
        $request->attributes->set('_locale', $locale);

        return $next($request);
    }
}
