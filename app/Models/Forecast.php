<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{

    protected $fillable = [
        'city',
        'temp',
        'feels_like',
        'pressure',
        'humidity',
    ];
}
