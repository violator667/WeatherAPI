<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\WeatherController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WeatherController::class, 'index'])->name('home');
Route::post('/', [WeatherController::class, 'getWeather'])->name('weather');

Route::get('/test/{city}', function () {
    try {
        $geo = new \App\Services\GeoApiService();
        $geo->callApi(['q' => request()->get('city')]);

    }catch (\App\Exceptions\WeatherApiException $e) {
        return view('welcome')->with('message', $e);
    }

});
