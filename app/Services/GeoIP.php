<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeoIP
{
    public function get($ip)
    {
        $response = Http::baseUrl('https://api.ipgeolocation.io')
            ->get('ipgeo', [
                'apiKey' => '03cec845a9314b329f954931ed924011',
                'ip' => $ip
            ]);

        $data = $response->json();
        return $data;
    }
}