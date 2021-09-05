<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * @var \App\Repositories\CartRepository
     */
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        //$cart = app('cart'); //app()->make('cart'); App::make('cart')

        //$cart = App::make(CartRepository::class);

        /*($total = $cart->sum(function($item) {
            return $item->quantity * $item->product->price;
        });*/

        return view('store.cart', [
            'cart' => $this->cart->all(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['int', 'min:1', 'max:10'],
        ]);

        /*$cart = Cart::where([
            'cookie_id' => $this->getCookieId(),
            'product_id' => $request->input('product_id'),
        ])->first();

        if ($cart) {

            $cart->update([
                'user_id' => Auth::id(),
                'quantity' => $cart->quantity + $request->input('quantity', 1),
            ]);

        } else {

            Cart::create([
                'cookie_id' => $this->getCookieId(),
                'user_id' => Auth::id(),
                'product_id' => $request->input('product_id'),
                'quantity' => $request->input('quantity', 1),
            ]);
        }*/

        // UPDATE carts SET quantity = quantity + 1
        /*Cart::updateOrCreate([
            'cookie_id' => app('cart.id'),
            'product_id' => $request->input('product_id'),
        ],[
            'user_id' => Auth::id(),
            'quantity' => DB::raw('quantity + ' . $request->input('quantity', 1)),
        ]);*/

        $item = $this->cart->add(
            $request->input('product_id'), 
            $request->input('quantity', 1)
        );

        return redirect()->back()->with('success', 'Product added to cart.');
    }

}
