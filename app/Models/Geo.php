<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Geo extends Model
{


    protected $fillable = [
        'city',
        'country',
        'lat',
        'lon',
    ];
}
