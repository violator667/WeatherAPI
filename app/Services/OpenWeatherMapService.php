<?php


namespace App\Services;


use App\Interfaces\ApiInterface;
use App\Traits\CallApi;

/**
 * Class OpenWeatherMapService
 * @package App\Services
 */
class OpenWeatherMapService implements ApiInterface
{
    use CallApi;

    /**
     * @var string
     */
    private string $apiKey;
    /**
     * @var string
     */
    private string $apiUrl;
    /**
     * @var object
     */
    private object $apiResponse;

    /**
     * OpenWeatherMapService constructor.
     */
    public function __construct()
    {
        $this->apiKey = config('api.owm_api_key');
        $this->apiUrl = config('api.own_api_ulr');
    }

    /**
     * @param array $data
     * @return string
     */
    public function buildRequestUrl(array $data): string
    {
        /*
         * ['lon','lat']
         */
        $requestUrl = $this->apiUrl.'appid='.$this->apiKey.'&units=metric';
        foreach($data as $key => $value) {
            $requestUrl .= '&'.$key.'='.$value;
        }

        return $requestUrl;
    }


    /**
     * @param string $body
     * @return array
     */
    public function mapDesiredData(string $body): array
    {
        $json = json_decode($body);

            return [
                'city' => $json->name,
                'temp' => $json->main->temp,
                'feels_like' => $json->main->feels_like,
                'pressure' => $json->main->pressure,
                'humidity' => $json->main->humidity
            ];

    }
}
