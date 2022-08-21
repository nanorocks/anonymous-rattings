<?php

namespace App\Controllers;

use App\Resource\JsonResource;
use App\Services\RatingService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RatingController
{
    public RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Load all rating grouped by slug with total rating
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {
        return JsonResource::handle($response, $this->ratingService->index());
    }

    /**
     * Get single rating group by slag distinct ip and total rate
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function rating(Request $request, Response $response, $args)
    {
        return JsonResource::handle($response, $this->ratingService->rating($request, $args));
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
        return JsonResource::handle($response, $this->ratingService->store($request));
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
        return JsonResource::handle($response, $this->ratingService->update($request));
    }

    /**
     * Remove rating if slug and ip are same
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function remove(Request $request, Response $response, $args)
    {
        return JsonResource::handle($response, $this->ratingService->remove($request, $args));
    }
}
