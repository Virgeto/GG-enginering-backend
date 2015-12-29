<?php


namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use App\Enums\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthJwtRequest;


/**
 * Provide JWT (JSON Web Token) authentication.
 *
 * Class AuthJwtController
 * @package App\Http\Controllers\Api
 * @link https://github.com/tymondesigns/jwt-auth
 */
class AuthJwtController extends Controller
{

    /**
     * Authenticate the user using JWT.
     *
     * @param AuthJwtRequest $request
     *
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function authenticate(AuthJwtRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        // Attempt to verify the credentials and create a token for the user
        if (!$token = JWTAuth::attempt($credentials)) {

            $response = $this->response->error(ResponseCode::UNAUTHORIZED, trans('texts.invalid_credentials'));

        } else {

            $data = [
                'token' => $token,
                'user' => JWTAuth::authenticate($token)
            ];

            $response = $this->response->ok($data);

        }

        return $response;
    }

    /**
     * The purpose of this action is to refresh the token. New token is returned
     * in the response header as "Authorization Bearer myrefreshedtoken". All this
     * logic is in Tymon\JWTAuth\Middleware\RefreshToken middleware.
     *
     * @param AuthJwtRequest $request
     * @return mixed
     */
    public function refresh(AuthJwtRequest $request)
    {
        $token = JWTAuth::parseToken()->refresh();

        return $this->response->ok(['token' => $token]);
    }


}
