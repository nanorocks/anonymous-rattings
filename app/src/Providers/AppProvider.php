<?php

namespace App\Providers;

use App\Middlewares\CorsMiddleware;
use App\Router\SlimRouter;
use DI\Container;
use Slim\App;

class AppProvider
{
    /**
     * App provider init
     *
     * @param App $app
     * @param Container $container
     * @param array $config
     * @return void
     */
    public static function start(App $app, Container $container, array $config)
    {
        $app->addRoutingMiddleware();

        $container->set('config', $config);

        $app->add(new CorsMiddleware());

        ConsoleProvider::handle($app, $container);

        DatabaseProvider::handle($container, $config);

        DiProvider::handle($container);

        SlimRouter::handle($app, $config);

        $app->addErrorMiddleware($config['show_errors'], $config['show_errors'], $config['show_errors']);

        $app->run();
    }
}
