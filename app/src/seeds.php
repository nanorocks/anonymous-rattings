<?php

use App\Models\Rating;
use App\Providers\DatabaseProvider;
use DI\Container;
use Illuminate\Support\Facades\DB;

require __DIR__ . './../vendor/autoload.php';

$config = require_once __DIR__ . './../src/config.php';

$container = new Container();

DatabaseProvider::handle($container, $config);

$manager = $container->get('orm');

$faker = Faker\Factory::create();

for ($i = 0; $i < 50; $i++) {
    $dataset = [
        Rating::SLUG => $faker->slug(),
        Rating::IP => $faker->ipv4(),
        Rating::RATE => $faker->numberBetween(0, 10)
    ];

    $manager::table('ratings')->insert($dataset);
}

echo "Seeding completed!\n";
