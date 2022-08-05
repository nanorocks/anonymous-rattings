<?php

namespace App\Services;

use App\Models\Ratting;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface IRattingService
{
    public function index(): Collection;

    public function ratting(Request $request, $args): Ratting;

    public function store(Request $request): ?Collection;

    public function update(Request $request): ?Collection;

    public function remove(Request $request): ?Ratting;
}
