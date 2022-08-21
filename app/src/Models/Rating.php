<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Rating extends Eloquent
{
    public const SLUG = 'slug';

    public const IP = 'ip';

    public const RATE = 'rate';

    protected $fillable = [
        self::SLUG,
        self::IP,
        self::RATE,
    ];
}
