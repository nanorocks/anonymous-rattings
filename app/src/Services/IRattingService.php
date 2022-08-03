<?php

namespace App\Services;

interface IRattingService
{
    public function index();

    public function ratting($request);

    public function store($request);

    public function remove($request);
}