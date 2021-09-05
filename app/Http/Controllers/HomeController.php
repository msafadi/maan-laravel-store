<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::with('category')->limit(8)
            ->latest()->get();

        $top = Product::with('category')->limit(4)
            ->orderByRaw('(SELECT sum(quantity) FROM order_items
                WHERE order_items.product_id = products.id) DESC')
            ->get();

        return view('store.home', [
            'featured_products' => $featured,
            'top_sellers' => $top,
        ]);
    }
}
