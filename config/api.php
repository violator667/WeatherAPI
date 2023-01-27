<?php

use Illuminate\Support\Facades\Facade;

return [
    /*
     * Open Weather Map GEO API
     */
    'geo_api_key' => env('GEO_API_KEY'),
    'geo_api_url' => env('GEO_API_URL'),

    /*
     * Open Weather Map Weather API
     */
    'owm_api_key' => env('OWM_API_KEY'),
    'own_api_ulr' => env('OWM_API_URL'),

    /*
     * Weatherapi.com API
     */
    'wac_api_key' => env('WAC_API_KEY'),
    'wac_api_url' => env('WAC_API_URL'),

    /*
     * Defaults
     */
    'default_city' => 'Gdynia',
];
