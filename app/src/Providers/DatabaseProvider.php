<?php

namespace App\Providers;

use DI\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container as IlluminateContainer;

class DatabaseProvider
{
    /**
     * Db eloqent orm
     *
     * @param Container $container
     * @param array $config
     * @return void
     */
    public static function handle(Container $container, array $config)
    {
        $capsule = new Manager();

        $capsule->addConnection($config['db']);

        $capsule->setEventDispatcher(new Dispatcher(new IlluminateContainer));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        $container->set('orm', $capsule);
    }
}
