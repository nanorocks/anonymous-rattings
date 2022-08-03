<?php

namespace App\Providers;

use DI\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container as IlluminateContainer;

class DatabaseProvider
{
    public static function handle(Container $container, array $config)
    {
        $capsule = new Manager();

        $capsule->addConnection($config['db']);

        // Set the event dispatcher used by Eloquent models... (optional)
        // $capsule->setEventDispatcher(new Dispatcher(new IlluminateContainer));

        // $capsule->setAsGlobal();

        $capsule->bootEloquent();

        $container->set('orm', function() use ($capsule)  {
            return $capsule;
        });
    }
}
