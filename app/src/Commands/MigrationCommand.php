<?php

namespace App\Commands;

use DI\Container;

class MigrationCommand
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container['orm'];
    }

    
}