<?php


namespace App\Enums;


class ResponseCode extends Enum
{
    /**
     * Standard response for successful HTTP requests.
     */
    const OK = 200;

    /**
     * The request has been fulfilled and resulted in a new resource being created.
     */
    const CREATED = 201;

    /**
     * The server has fulfilled the request but does not need to return an
     * entity-body.
     */
    const NO_CONTENT = 204;

    /**
     * The server cannot or will not process the request due to something that is
     * perceived to be a client error.
     */
    const BAD_REQUEST = 400;

    /**
     * Authentication is required and has failed.
     */
    const UNAUTHORIZED = 401;

    /**
     * The requested resource could not be found.
     */
    const NOT_FOUND = 404;

    /**
     * A request was made of a resource using a request method not supported by that
     * resource; for example, using GET on a form which requires data to be presented
     * via POST.
     */
    const METHOD_NOT_ALLOWED = 405;

    /**
     * The 422 (Unprocessable Entity) status code means the server understands the
     * content type of the request entity and the syntax of the request entity
     * is correct but was unable to process the contained instructions. This
     * status code is used for validation errors.
     */
    const UNPROCESSABLE_ENTITY = 422;

    /**
     * Indicates an expired or otherwise invalid token.
     */
    const TOKEN_EXPIRED_OR_INVALID = 498;

    /**
     * Indicates that a token is required.
     */
    const TOKEN_REQUIRED = 499;

    /**
     * A generic error message, given when an unexpected condition was encountered
     * and no more specific message is suitable.
     */
    const INTERNAL_SERVER_ERROR = 500;

    /**
     * The server is stating the account you have currently logged in as does not
     * have permission to perform the action you are attempting.
     */
    const PERMISSIONS_DENIED = 550;
}