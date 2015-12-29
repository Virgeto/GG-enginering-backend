<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\LanguageException;


class Language
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws LanguageException
     */
    public function handle($request, Closure $next)
    {
        $languages = explode(',', env('LANGUAGES'));
        $requestedLanguage = $request->header('Accept-Language');

        if (is_null($requestedLanguage) || strlen($requestedLanguage) > 2) {

            $requestedLanguage = env('DEFAULT_LANGUAGE');

        } elseif (!in_array($requestedLanguage, $languages)) {

            throw new LanguageException('Language not supported.');

        }

        app()->setLocale($requestedLanguage);

        return $next($request);
    }
}
