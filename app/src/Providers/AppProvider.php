<?php

namespace App\Providers;

use App\Middlewares\CorsMiddleware;
use App\Router\SlimRouter;
use DI\Container;
use Slim\App;

class AppProvider
{
    public static function start(App $app, Container $container, array $config)
    {
        $app->add(new CorsMiddleware());

        DatabaseProvider::handle($container, $config);

        DiProvider::handle($container);

        SlimRouter::handle($app);

        $app->run();
    }
}
