<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherRequest;
use App\Services\GeoApiService;
use App\Services\WeatherApiService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    private object $geoApiService;
    private object $weatherApiService;

    public function __construct(GeoApiService $geoService, WeatherApiService $weatherService)
    {
        $this->geoApiService = $geoService;
        $this->weatherApiService = $weatherService;
    }

    public function index()
    {
        return $this->weatherApiService->showWeather(config('api.default_city'));
    }

    public function getWeather(WeatherRequest $request)
    {
        return $this->weatherApiService->showWeather($request->get('city'));
    }
}
