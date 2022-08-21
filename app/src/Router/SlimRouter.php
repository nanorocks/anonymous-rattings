<?php

namespace App\Router;

use App\Middlewares\AuthMiddleware;
use App\Controllers\RatingController;
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
    public static function handle(SlimApp $app, array $config)
    {
        $app->get('/', function (Request $request, Response $response, $args) use ($config) {
            $response->getBody()->write($config['appName'] . " powered by Slim PHP v4!");
            return $response;
        });

        $app->get('/is_connected', function (Request $request, Response $response, $args) use ($config) {

            switch (connection_status()) {
                case CONNECTION_NORMAL:
                    $txt = 'Connection is in a normal state';
                    break;
                case CONNECTION_ABORTED:
                    $txt = 'Connection aborted';
                    break;
                case CONNECTION_TIMEOUT:
                    $txt = 'Connection timed out';
                    break;
                case (CONNECTION_ABORTED & CONNECTION_TIMEOUT):
                    $txt = 'Connection aborted and timed out';
                    break;
                default:
                    $txt = 'Unknown';
                    break;
            }

            $response->getBody()->write($txt);
            return $response;
        });

        $app->group('', function () use ($app) {
            $app->get('/ratings', RatingController::class . ':index');
            $app->get('/ratings/{slug}', RatingController::class . ':rating');
            $app->post('/ratings', RatingController::class . ':store');
            $app->put('/ratings', RatingController::class . ':update');
            $app->delete('/ratings/{slug}', RatingController::class . ':remove');
        })->add(new AuthMiddleware($config));
    }
}
