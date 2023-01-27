<?php


namespace App\Services;


use App\Interfaces\ApiInterface;
use App\Traits\CallApi;

/**
 * Class WeatherApiComService
 * @package App\Services
 */
class WeatherApiComService implements ApiInterface
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
     * WeatherApiComService constructor.
     */
    public function __construct()
    {
        $this->apiKey = config('api.wac_api_key');
        $this->apiUrl = config('api.wac_api_url');
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
        $requestUrl = $this->apiUrl.'&key='.$this->apiKey.'&q=';
        foreach($data as $value) {
            $requestUrl .= $value.',';
        }
        $requestUrl = substr($requestUrl, 0, -1);

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
                    'city' => $json->location->name,
                    'temp' => $json->current->temp_c,
                    'feels_like' => $json->current->feelslike_c,
                    'pressure' => $json->current->pressure_mb,
                    'humidity' => $json->current->humidity
        ];
    }
}
