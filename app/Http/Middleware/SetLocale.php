<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
        $availableLocales = ['ja', 'en', 'ru'];
        $defaultLocale = 'ja';

        // Session dan locale ni olish
        $locale = Session::get('locale', $defaultLocale);

        // Agar request da locale parametri bo'lsa
        if ($request->has('locale') && in_array($request->get('locale'), $availableLocales)) {
            $locale = $request->get('locale');
            Session::put('locale', $locale);
        }

        // Locale ni o'rnatish
        App::setLocale($locale);

        return $next($request);
    }
}

