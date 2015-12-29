<?php


namespace App\Http\Middleware;

use Closure;


class Paginate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $perPage = $request->get('per_page');

        if (empty($perPage)) {
            $perPage = app()['config']->get('pagination.per_page');
        }

        app()['config']->set('pagination.per_page', $perPage);

        return $next($request);
    }
}
