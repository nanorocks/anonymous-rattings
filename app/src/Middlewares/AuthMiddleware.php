<?php

namespace App\Middlewares;

use DI\Container;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Psr7\Response;

class AuthMiddleware
{
    /**
     * Auth service token validator
     *
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            $header = $request->getHeader('Authorization')[0];

            $token = explode(' ', $header)[1];

            $accessToken = 'f21a44635709c17ef568f177928565e1'; // get from config

            if ($token !== $accessToken) {
                throw new HttpForbiddenException($request);
            }
        } catch (Exception $e) {
            throw new HttpForbiddenException($request);
        }

        $response = $handler->handle($request);

        return $response;
    }
}
