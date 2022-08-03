<?php

namespace App\Router;



use App\Middlewares\AuthMiddleware;
use App\Controllers\RattingController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App as SlimApp;


class SlimRouter
{
    /**
     * Router
     *
     * @param SlimApp $app
     * @return void
     */
    public static function handle(SlimApp $app)
    {
        $app->get('/', function (Request $request, Response $response, $args) {
            $response->getBody()->write("Slim PHP v4!");
            return $response;
        });

        $app->group('', function () use ($app) {
            $app->get('/ratting', RattingController::class . ':index');
            $app->get('/ratting/:id', RattingController::class . ':ratting');
            $app->post('/§ratting', RattingController::class . ':store');
            $app->delete('/ratting', RattingController::class . ':remove');
        })->add(new AuthMiddleware());
    }
}
