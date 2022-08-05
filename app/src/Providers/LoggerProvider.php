<?php

namespace App\Providers;

use DI\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerProvider
{
    public static function handle(Container $container, array $config)
    {
        $log = new Logger($config['appName']);
        $log->pushHandler(new StreamHandler($config['logger']['path']));
        
        $container->set('logger', $log);
    }
}
