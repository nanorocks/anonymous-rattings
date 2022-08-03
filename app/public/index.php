<?php

use DI\Container;
use Slim\Factory\AppFactory;
use App\Providers\AppProvider;

require __DIR__ . './../vendor/autoload.php';

$config = require_once __DIR__ . './../src/config.php';

ini_set('display_errors', $config['show_errors']);
ini_set('display_startup_errors', $config['show_errors']);
error_reporting(E_ALL);

$container = new Container();

AppFactory::setContainer($container);

AppProvider::start(AppFactory::create(), $container, $config);