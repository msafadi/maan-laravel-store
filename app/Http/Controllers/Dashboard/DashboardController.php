<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Currency;
use App\Services\GeoIP;
use App\Services\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*$geoIp = new GeoIP();
        $geo = $geoIp->get( '45.146.15.23' );

        $currency = new Currency();
        $ex = $currency->getBulk($geo['currency']['code'], ['USD', 'JOD']);

        $weather = (new Weather())->getByCity('Gaza');*/

        return view('dashboard.dashboard', [

            /*'geo' => $geo,
            'exchange' => $ex['results'],
            'weather' => $weather,*/
        ]);
    }
}
