<?php

namespace App\Resource;

use Psr\Http\Message\ResponseInterface as Response;

class JsonResource
{
    /**
     * Undocumented function
     *
     * @param Response $response
     * @param [type] $playload
     * @return void
     */
    public static function handle(Response $response, $playload)
    {
        $response->getBody()->write(json_encode($playload));
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}