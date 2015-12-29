<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use App\Libraries\ResponseBuilder;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($this->isApiRequest($request)) {

            return $this->apiException($e);

        }

        return parent::render($request, $e);
    }

    /**
     * Check if the request is made to API route.
     *
     * @param $request
     * @return bool
     */
    private function isApiRequest($request)
    {
        $fistSegment = array_first($request->segments(), function ($key, $value) {
            return $value;
        });

        if ($fistSegment == 'api') {
            return true;
        }

        return false;
    }

    /**
     * Create API Exception response by given Exception.
     *
     * @param $exception
     * @return JsonResponse
     */
    private function apiException($exception)
    {
        $response = new ResponseBuilder(new JsonResponse());

        return $response->exception($exception);
    }
}
