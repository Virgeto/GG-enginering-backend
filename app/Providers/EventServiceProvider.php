<?php


namespace App\Providers;

use Event;
use Illuminate\Http\JsonResponse;
use App\Libraries\ResponseBuilder;
use App\Exceptions\TokenAbsentException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\SomeEventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        $response = new ResponseBuilder(new JsonResponse());

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        |
        | These are events used to return custom JSON response when error occurs
        | using JWT Library. This type of event listening is compatible with
        | Laravel 4.* that JWT Library currently supports.
        |
        */
        Event::listen('tymon.jwt.invalid', function ($exception) {

            throw $exception;

        });

        Event::listen('tymon.jwt.expired', function ($exception) {

            throw $exception;

        });

        Event::listen('tymon.jwt.absent', function () use ($response) {

            $exception = new TokenAbsentException();

            return $response->exception($exception);
        });

        Event::listen('tymon.jwt.user_not_found', function () use ($response) {

            $exception = new TokenInvalidException();

            return $response->exception($exception);

        });
    }
}