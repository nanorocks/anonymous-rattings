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
        header("Content-Type: application/json");
        $response->getBody()->write(json_encode($playload, true));
        
        return $response;
    }
}