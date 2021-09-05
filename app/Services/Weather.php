<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Weather
{
    protected $apiKey = '5b111e3737b3102908663fd62419fd0b';

    protected $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function getByCity($city)
    {
        return Http::baseUrl($this->baseUrl)
            ->get('weather', [
                'appid' => $this->apiKey,
                'q' => $city,
                'units' => 'metric',
                'lang' => 'ar',
            ])
            ->json();
    }
}