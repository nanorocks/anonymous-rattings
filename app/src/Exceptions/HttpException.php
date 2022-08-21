<?php

namespace App\Exceptions;

use Slim\Exception\HttpForbiddenException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpException as ExceptionHttpException;
use Slim\Exception\HttpGoneException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;

class HttpException
{
    public const NOT_FOUND = 404;

    public const FORBIDDEN = 401;

    public const SERVER_ERORR = 500;

    public const GONE = 410;

    public const ALREADY_EXIST = 405;

    public static function handle(int $code, Request $request)
    {
        $errors = [
            self::NOT_FOUND => new HttpNotFoundException($request),
            self::FORBIDDEN => new HttpForbiddenException($request),
            self::SERVER_ERORR => new HttpInternalServerErrorException($request),
            self::GONE => new HttpGoneException($request),
            self::ALREADY_EXIST => new HttpMethodNotAllowedException($request)
        ];

        return $errors[$code];
    }
}
