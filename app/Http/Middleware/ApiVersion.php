<?php


namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ApiVersionException;


class ApiVersion
{
    /**
     * Currently possible API versions.
     *
     * @var array
     */
    private $currentVersions = [
        '1'
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $version = $request->header('Version');

        if (is_null($version)) {
            throw new ApiVersionException(trans('texts.api_version_is_missing'));
        }

        if (!in_array($version, $this->currentVersions)) {
            throw new ApiVersionException(trans('texts.api_version_is_incorrect'));
        }

        $route = $request->route();
        $action = $route->getAction();
        $action['uses'] = str_replace('{version}', 'V' . $version, $action['uses']);
        $action['namespace'] = str_replace('{version}', 'V' . $version, $action['namespace']);

        $route->setAction($action);

        return $next($request);
    }
}
