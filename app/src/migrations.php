<?php

use App\Models\Ratting;
use App\Providers\DatabaseProvider;
use DI\Container;

require __DIR__ . './../vendor/autoload.php';

$config = require_once __DIR__ . './../src/config.php';

$container = new Container();

DatabaseProvider::handle($container, $config);

$manager = $container->get('orm');

$manager = $this->getDoctrine()->getManager();

// Ratting
$manager::schema()->create('rattings', function ($table) {
    $table->increments('id');
    $table->string(Ratting::SLUG);
    $table->integer(Ratting::RATE);
    $table->string(Ratting::IP);
    $table->timestamps();
});