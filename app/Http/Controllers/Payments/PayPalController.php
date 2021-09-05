<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;

class PayPalController extends Controller
{

    public function create(Order $order)
    {
        if ($order->payment_status == 'paid') {
            abort(404);
        }

        /**
         * @var \PayPalCheckoutSdk\Core\PayPalHttpClient
         */
        $client = app('paypal.client');

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order->number,
                "amount" => [
                    "value" => $order->total,
                    "currency_code" => "ILS"
                ]
            ]],
            "application_context" => [
                "cancel_url" => url(route('paypal.cancel', $order->id)),
                "return_url" => url(route('paypal.return', $order->id)),
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //dd($response);

            if ($response->statusCode == 201) {
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }
        } catch (HttpException $ex) {
            $order->payment_status = 'failed';
            $order->save();

            return redirect('/')->with('error', 'Payment failed!');

            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function callback(Request $request, Order $order)
    {
        if ($order->payment_status == 'paid') {
            abort(404);
        }

        $token = $request->query('token');
        if (!$token) {
            abort(404);
        }

        $client = app('paypal.client');

        $request = new OrdersCaptureRequest($token);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //dd($response);

            if ($response->statusCode == 201 && $response->result->status == 'COMPLETED') {
                $order->payment_status = 'paid';
                $order->save();

                $order->payments()->create([
                    'amount' => $response->result->purchase_units[0]->amount->value,
                    'payload' => $response->result,
                    'method' => 'paypal',
                ]);
            }

            return redirect('/')->with('success', 'Payment comepleted!');

            
        } catch (HttpException $ex) {
            $order->payment_status = 'failed';
            $order->save();

            return redirect('/')->with('error', 'Payment failed!');

            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        $order->payment_status = 'failed';
        $order->save();

        return redirect('/')->with('error', 'Payment failed!');
    }
}
