<?php

namespace App\Middlewares;

use DI\Container;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Exceptions\HttpException;
class AuthMiddleware
{
    public array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

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

            $accessToken = $this->config['accessToken'];

            if ($token !== $accessToken) {
                throw HttpException::handle(HttpException::FORBIDDEN, $request);
            }
        } catch (Exception $e) {
            throw HttpException::handle(HttpException::FORBIDDEN, $request);
        }

        $response = $handler->handle($request);

        return $response;
    }
}
