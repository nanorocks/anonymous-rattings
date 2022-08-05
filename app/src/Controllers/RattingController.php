<?php

namespace App\Controllers;

use App\Resource\JsonResource;
use App\Services\RattingService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class RattingController
{
    public RattingService $rattingService;

    public function __construct(RattingService $rattingService)
    {
        $this->rattingService = $rattingService;
    }
    
    /**
     * Load all ratting grouped by slug with total ratting
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {
        return JsonResource::handle($response, $this->rattingService->index());
    }

    /**
     * Get single ratting group by slag distinct ip and total rate
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function ratting(Request $request, Response $response, $args)
    {
        return JsonResource::handle($response, $this->rattingService->ratting($request, $args));
    }

    /**
     * Store rating by slug
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function store(Request $request, Response $response)
    {
        return JsonResource::handle($response, $this->rattingService->store($request));
    }

    /**
     * Update rate by slug and ip
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        return JsonResource::handle($response, $this->rattingService->update($request));
    }

    /**
     * Remove ratting if slug and ip are same
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function remove(Request $request, Response $response, $args)
    {
        return JsonResource::handle($response, $this->rattingService->remove($request, $args));
    }
}
