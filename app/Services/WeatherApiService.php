<?php


namespace App\Services;


use App\Exceptions\WeatherApiException;
use App\Models\Forecast;
use App\Models\Geo;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;


/**
 * Class WeatherApiService
 * @package App\Services
 */
class WeatherApiService
{
    /**
     * @var GeoApiService
     */
    private GeoApiService $geoApiService;
    /**
     * @var array
     */
    private array $availableApis;
    /**
     * @var array
     */
    private array $weatherForecasts;
    /**
     * @var string
     */
    private string $currentCity;

    /**
     * WeatherApiService constructor.
     * @param GeoApiService $geoService
     * @param OpenWeatherMapService $owmService
     * @param WeatherApiComService $wacService
     */
    public function __construct(
        GeoApiService $geoService,
        OpenWeatherMapService $owmService,
        WeatherApiComService $wacService
    ) {
        $this->geoApiService = $geoService;
        $this->availableApis = ['owm' => $owmService, 'wac' => $wacService];
    }

    /**
     * @param string $city
     * @return Object
     */
    public function showWeather(string $city): Object
    {
        $this->currentCity =$city;
        $this->geoApiService->setCity($city);
        try {
            $location = $this->getLocationData($this->currentCity);
            $locationArray = ['lat' => $location->lat, 'lon' => $location->lon];
            foreach ($this->availableApis as $key => $value) {
                try {
                    $this->weatherForecasts[$key] = $value->callApi($locationArray);
                }catch(WeatherApiException $e) {
                    abort(500);
                }
            }
            $forecast = $this->mergeData();
            return view('welcome')->with('forecast',$forecast);
        }catch(WeatherApiException $e) {
            throw ValidationException::withMessages(['city' => $e->getMessage()]);
        }
    }

    /**
     * @param string $city
     * @return Geo
     * @throws WeatherApiException
     */
    public function getLocationData(string $city): Geo
    {
        $cacheKey = preg_replace('/\s+/', '', $city);
        $search = Cache::remember('geo_'.$cacheKey, 120, static function() use($city) {
            return Geo::where('city', $city)->first();
        });
        if($search === null) {
            try {
                $search = $this->geoApiService->callApi(['q' => $city]);
                $this->currentCity = $search->city;
            }catch(WeatherApiException $e) {
                throw new WeatherApiException($e->getMessage());
            }
        }

        return $search;
    }

    /**
     * @return Forecast
     */
    private function mergeData(): Forecast
    {
        $divideBy = count($this->availableApis);
        $mergedData = ['temp' => '0','feels_like' => '0','pressure' => '0', 'humidity' => '0'];

        foreach($this->availableApis as $key => $value) {
            foreach($this->weatherForecasts[$key] as $k => $v) {
                    if($k!='city') {
                        $mergedData[$k] += $v;
                    }
            }
        }
        foreach ($mergedData as $key => $value) {
            $mergedData[$key] = $value/$divideBy;
        }
        $city = $this->currentCity;
        return Cache::remember('forecast_'.$this->currentCity, 120, static function() use($city, $mergedData)  {
            return Forecast::create(
                [
                    'city' => $city,
                    'temp' => $mergedData['temp'],
                    'feels_like' => $mergedData['feels_like'],
                    'pressure' => $mergedData['pressure'],
                    'humidity' => $mergedData['humidity']
                ]
            );
        });
    }


}
