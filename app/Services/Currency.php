<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Currency
{
    protected $apiKey = '073b5c385d9963192f30';
    
    public function get($from, $to)
    {
        $q = strtoupper($from) . '_' . strtoupper($to);
        $ch = curl_init("https://free.currconv.com/api/v7/convert?apiKey={$this->apiKey}&q={$q}&compact=y");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);

        return json_decode($result, true);
    }

    public function getBulk($from, array $to)
    {
        $q = [];
        foreach ($to as $value) {
            $q[] = strtoupper($value) . '_' . strtoupper($from);
        }
        return Http::baseUrl('https://free.currconv.com/api/v7')
            ->get('convert', [
                'apiKey' => $this->apiKey,
                'q' => implode(',', $q),
            ])
            ->json();
    }
}