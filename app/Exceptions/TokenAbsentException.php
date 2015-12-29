<?php


namespace App\Exceptions;

use App\Enums\ResponseCode;
use Tymon\JWTAuth\Exceptions\JWTException;


class TokenAbsentException extends JWTException
{
    /**
     * @var integer
     */
    protected $statusCode = ResponseCode::TOKEN_REQUIRED;
}