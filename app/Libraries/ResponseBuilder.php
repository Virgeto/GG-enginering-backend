<?php


namespace App\Libraries;

use App\Enums\ResponseCode;
use Illuminate\Http\JsonResponse;
use App\Exceptions\TokenAbsentException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


/**
 * This class makes a custom API response.
 *
 * Class ResponseBuilder
 * @package App\Libraries
 */
class ResponseBuilder
{

    /**
     * Response object that will be returned to the user.
     *
     * @var JsonResponse
     */
    private $response;

    /**
     * Success result that will be returned in the response object.
     *
     * @var $result
     */
    private $result = [];

    public function __construct(JsonResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Create default OK response that return only data.
     *
     * @param array $data
     * @return JsonResponse
     */
    public function ok($data = [])
    {
        $this->addData($data)
            ->addToResponse(ResponseCode::OK);

        return $this->response;
    }

    /**
     * Return status code when new record is created.
     *
     * @return JsonResponse
     */
    public function created()
    {
        $this->addToResponse(ResponseCode::CREATED);

        return $this->response;
    }

    /**
     * The server has fulfilled the request but does not need to return
     * anything back to the client.
     *
     * @return JsonResponse
     */
    public function noContent()
    {
        $this->addToResponse(ResponseCode::NO_CONTENT);

        return $this->response;
    }

    /**
     * Create error response.
     *
     * @param $code
     * @param $message
     * @return $this
     */
    public function error($code, $message = '')
    {
        $this->addCorsHeaders()
            ->addMessage($message)
            ->addToResponse($code);

        return $this->response;
    }

    /**
     * Prepare response when exception is occurred.
     *
     * @param $exception
     * @return JsonResponse
     */
    public function exception($exception)
    {
        $details = $this->prepareExceptionDetails($exception);

        $this->addCorsHeaders()
            ->addMessage($details['message'])
            ->addToResponse($details['code']);

        return $this->response;
    }

    /**
     * Add currently built result to the response object.
     *
     * @param $code
     */
    private function addToResponse($code)
    {
        $this->response->setStatusCode($code);
        $this->response->setData($this->result);
    }

    /**
     * Add data to the result.
     *
     * @param $data
     * @return $this
     */
    private function addData($data)
    {

        if (!is_array($data)) {

            $data = $data->toArray();

        }

        if (isset($data['data'])) {

            $this->result += $data;

        } else {

            $this->result['data'] = $data;

        }

        return $this;
    }

    /**
     * Add message to result.
     *
     * @param $message
     * @return $this
     */
    private function addMessage($message)
    {

        if (!is_array($message)) {
            $message = [$message];
        }

        $this->result['errors'] = $message;

        return $this;
    }

    /**
     * Return appropriate response code for raised exception.
     *
     * @param $exception
     * @return array
     */
    private function prepareExceptionDetails($exception)
    {
        $lookup = $this->getLookup();

        $default = [
            'code' => ResponseCode::INTERNAL_SERVER_ERROR,
            'message' => env('APP_ENV') == 'production' ? trans('texts.server_error_please_try_again_later') : $exception->getMessage()
        ];

        return isset($lookup[get_class($exception)]) ? $lookup[get_class($exception)] : $default;
    }

    /**
     * Add headers needed for CORS.
     *
     * @return $this
     */
    private function addCorsHeaders()
    {
        if (isset($_SERVER['SERVER_SOFTWARE']) && preg_match('/nginx/', $_SERVER['SERVER_SOFTWARE'])) {
            $accessControlAllowCredentials = 'false';

            if (env('ACCESS_CONTROL_ALLOW_HEADERS')) {
                $accessControlAllowCredentials = 'true';
            }

            $this->response->header('Access-Control-Allow-Origin', env('ACCESS_CONTROL_ALLOW_ORIGIN'));
            $this->response->header('Access-Control-Allow-Credentials', $accessControlAllowCredentials);
            $this->response->header('Access-Control-Allow-Methods', env('ACCESS_CONTROL_ALLOW_METHODS'));
            $this->response->header('Access-Control-Allow-Headers', env('ACCESS_CONTROL_ALLOW_HEADERS'));
        }

        return $this;
    }

    /**
     * Contain exceptions lookup.
     *
     * @return array
     */
    private function getLookup()
    {
        return [
            NotFoundHttpException::class => [
                'code' => ResponseCode::NOT_FOUND,
                'message' => trans('texts.address_not_found')
            ],
            ModelNotFoundException::class => [
                'code' => ResponseCode::BAD_REQUEST,
                'message' => trans('texts.the_request_cannot_be_fulfilled_due_to_bad_syntax')
            ],
            MethodNotAllowedHttpException::class => [
                'code' => ResponseCode::METHOD_NOT_ALLOWED,
                'message' => trans('texts.the_request_can_not_be_done')
            ],
            AccessDeniedHttpException::class => [
                'code' => ResponseCode::PERMISSIONS_DENIED,
                'message' => trans('texts.you_do_not_have_permissions_for_this_action')
            ],
            TokenInvalidException::class => [
                'code' => ResponseCode::TOKEN_EXPIRED_OR_INVALID,
                'message' => trans('texts.you_must_login_in_your_account')
            ],
            TokenExpiredException::class => [
                'code' => ResponseCode::TOKEN_EXPIRED_OR_INVALID,
                'message' => trans('texts.you_must_login_in_your_account')
            ],
            JWTException::class => [
                'code' => ResponseCode::TOKEN_REQUIRED,
                'message' => trans('texts.error_when_trying_to_connect')
            ],
            TokenAbsentException::class => [
                'code' => ResponseCode::TOKEN_REQUIRED,
                'message' => trans('texts.error_when_trying_to_connect')
            ]
        ];
    }

}