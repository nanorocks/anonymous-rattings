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
            $app->get('/rattings', RattingController::class . ':index');
            $app->get('/rattings/{slug}', RattingController::class . ':ratting');
            $app->post('/rattings', RattingController::class . ':store');
            $app->put('/rattings', RattingController::class . ':update');
            $app->delete('/rattings/{slug}', RattingController::class . ':remove');
        })->add(new AuthMiddleware($config));
    }
}
