<?php


namespace App\Traits;


use App\Exceptions\WeatherApiException;
use App\Models\Geo;
use Illuminate\Support\Facades\Http;

/**
 * Trait CallApi
 * @package App\Traits
 */
trait CallApi
{
    /**
     * @param array $searching
     * @return array|Geo|WeatherApiException
     * @throws WeatherApiException
     */
    public function callApi(array $searching): array|Geo|WeatherApiException
    {
        $this->apiResponse = Http::get($this->buildRequestUrl($searching));
        if($this->success()) {
            return $this->mapDesiredData($this->apiResponse->body());
        }

        throw new WeatherApiException('Something went wrong when trying to get desired Location');
    }

    /**
     * @return bool
     */
    public function success(): bool
    {
        if($this->apiResponse->status()!==200 && $this->apiResponse->successful() !== true) {
            return false;
        }
        return true;
    }
}
