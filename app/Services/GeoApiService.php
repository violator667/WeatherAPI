<?php


namespace App\Services;


use App\Exceptions\WeatherApiException;
use App\Interfaces\ApiInterface;
use App\Models\Geo;
use App\Traits\CallApi;

/**
 * Class GeoApiService
 * @package App\Services
 */
class GeoApiService implements ApiInterface
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
     * @var string
     */
    private string $searchedCity;
    /**
     * @var object
     */
    private object $apiResponse;

    /**
     * GeoApiService constructor.
     */
    public function __construct()
    {
        $this->apiKey = config('api.geo_api_key');
        $this->apiUrl = config('api.geo_api_url');
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->searchedCity = ucfirst($city);
    }

    /**
     * @param array $data
     * @return string
     */
    public function buildRequestUrl(array $data): string
    {
        $requestUrl = $this->apiUrl.$this->apiKey;
        foreach($data as $key => $value) {
            $requestUrl .= '&'.$key.'='.$value;
        }

        return $requestUrl;
    }

    /**
     * @param string $body
     * @return Geo
     * @throws WeatherApiException
     */
    public function mapDesiredData(string $body): Geo
    {
        $json = json_decode($body);
        if($this->searchedCity === $json[0]->name) {
            return Geo::create(
                [
                    'city' => $json[0]->name,
                    'country' => $json[0]->country,
                    'lat' => $json[0]->lat,
                    'lon' => $json[0]->lon,
                ]
            );
        }
        throw new WeatherApiException('No match for your query.');
    }
}
