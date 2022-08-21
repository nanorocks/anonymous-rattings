<?php

use App\Models\Rating;
use App\Providers\DatabaseProvider;
use DI\Container;

require __DIR__ . './../vendor/autoload.php';

$config = require_once __DIR__ . './../src/config.php';

$container = new Container();

DatabaseProvider::handle($container, $config);

$manager = $container->get('orm');

// Rating
$manager::schema()->create('ratings', function ($table) {
    $table->increments('id');
    $table->string(Rating::SLUG);
    $table->integer(Rating::RATE);
    $table->string(Rating::IP);
    $table->timestamps();
});
