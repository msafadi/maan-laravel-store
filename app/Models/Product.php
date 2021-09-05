<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(
            Order::class, 'order_items', 'product_id', 'order_id', 'id', 'id'
        )
        ->withPivot([
            'price', 'quantity', 'product_name'
        ])
        ->using(OrderItem::class)
        ->as('item');
    }

    // permalink
    public function getPermalinkAttribute()
    {
        return route('products.show', $this->slug);
    }

    // purchase_price
    public function getPurchasePriceAttribute()
    {
        if ($this->sale_price) {
            return $this->sale_price;
        }
        return $this->price;
    }

}

