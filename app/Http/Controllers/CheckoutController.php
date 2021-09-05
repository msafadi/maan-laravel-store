<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{

    /**
     * @var \App\Repositories\CartRepository
     */
    protected $cart;

    /**
     * @param CartRepository $cart
     * @return void
     */
    public function __construct(CartRepository $cart)
    {
        //$this->middleware('auth');
        $this->cart = $cart;
    }

    public function create()
    {
        return view('store.checkout', [
            'cart' => $this->cart,
            'user' => Auth::check()? Auth::user() : new User(),
            'countries' => Countries::getNames('ar'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'billing_firstname' => 'required',
            'billing_lastname' => 'required',
            'billing_email' => 'required|email',
            'billing_phone' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_postalcode' => 'required',
            'billing_country' => 'required',
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'total' => $this->cart->total(),
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create($request->all());
            foreach ($this->cart->all() as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->purchase_price,
                    'quantity' => $item->quantity,
                ]);
            }

            $this->cart->empty();

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return Redirect::route('payments.paypal', $order->id);
        
    }
}
