<?php

namespace App\Services;

use App\Models\Ratting;

class RattingService implements IRattingService
{
    public function index()
    {
        return Ratting::all();
    }

    public function ratting($request)
    {
        return Ratting::all();
    }

    public function store($request)
    {
        /**
         * Check request ip address exist in db
         * In not store ratting else throw http exeption
         */
        return Ratting::all();
    }

    public function remove($request)
    {
        return Ratting::all();
    }
}