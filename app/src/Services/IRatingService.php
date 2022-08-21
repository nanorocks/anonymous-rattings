<?php

namespace App\Services;

use App\Models\Rating;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface IRatingService
{
    public function index(): Collection;

    public function rating(Request $request, $args): ?Rating;

    public function store(Request $request): ?Collection;

    public function update(Request $request): ?Collection;

    public function remove(Request $request): ?Collection;
}
