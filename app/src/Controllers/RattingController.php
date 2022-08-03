<?php

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RattingController
{
    public $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        print_r($this->container->get('orm'));
        die();
        $response->getBody()->write("Hello ratting!");
        return $response;
    }

    public function ratting(Request $request, Response $response)
    {
        $response->getBody()->write("Hello world!");
        return $response;
    }

    public function store(Request $request, Response $response)
    {
        /**
         * Check request ip address exist in db
         * In not store ratting else throw http exeption
         */
        $response->getBody()->write("Hello world!");
        return $response;
    }

    public function remove(Request $request, Response $response)
    {
        $response->getBody()->write("Hello world!");
        return $response;
    }
}
