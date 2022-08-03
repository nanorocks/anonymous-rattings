<?php

namespace App\Controllers;

use App\Models\Ratting;
use App\Resource\JsonResource;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class RattingController
{
    
    public function index(Request $request, Response $response, $args)
    {
        return JsonResource::handle($response, Ratting::all());
    }

    public function ratting(Request $request, Response $response)
    {
        return JsonResource::handle($response, Ratting::all());
    }

    public function store(Request $request, Response $response)
    {
        /**
         * Check request ip address exist in db
         * In not store ratting else throw http exeption
         */
        return JsonResource::handle($response, Ratting::all());
    }

    public function remove(Request $request, Response $response)
    {
        return JsonResource::handle($response, Ratting::all());
    }
}
