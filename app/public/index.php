<?php

use DI\Container;
use Slim\Factory\AppFactory;
use App\Providers\AppProvider;

require __DIR__ . './../vendor/autoload.php';

$config = require_once __DIR__ . './../src/config.php';

$container = new Container();

AppFactory::setContainer($container);

AppProvider::start(AppFactory::create(), $container, $config);