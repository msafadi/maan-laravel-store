<?php

namespace App\Repositories;

use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Cart implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
        $this->all();
    }

    public function all()
    {
        if (!$this->items->count()) {
            $this->items = CartModel::with('product')
                ->where('cookie_id', $this->getCartId())
                ->get();
        }
        return $this->items;
    }

    public function add($item, $quantity = 1)
    {
        $cart = CartModel::updateOrCreate([
            'cookie_id' => $this->getCartId(),
            'product_id' => $item,
        ],[
            'user_id' => Auth::id(),
            'quantity' => DB::raw('quantity + ' . $quantity),
        ]);

        $this->items->push($cart);

        return $cart;
    }

    public function total()
    {
        return $this->all()->sum(function($item) {
            return $item->quantity * $item->product->purchase_price;
        });
    }

    public function empty()
    {
        CartModel::where('cookie_id', $this->getCartId())->delete();
    }

    protected function getCartId()
    {
        $cookie_id = Cookie::get('cart_cookie_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_cookie_id', $cookie_id, 60 * 24 * 30);
        }
        return $cookie_id;
    }
}