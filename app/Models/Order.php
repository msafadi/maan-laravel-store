<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'tax', 'discount', 'total',
        'billing_firstname',
        'billing_lastname',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_postalcode',
        'billing_country',
        'shipping_firstname',
        'shipping_lastname',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_postalcode',
        'shipping_country',
    ];

    protected static function booted()
    {
        static::creating(function(Order $order) {
            $now = Carbon::now();
            $max = Order::whereYear('created_at', $now->year)->max('number');
            if (!$max) {
                $max = $now->year . '00000';
            }
            $order->number = $max + 1;
            
            $order->shipping_firstname = $order->shipping_firstname ?: $order->billing_firstname;
            $order->shipping_lastname = $order->shipping_lastname ?: $order->billing_lastname;
        });
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id'
        )
        ->withPivot([
            'price', 'quantity', 'product_name'
        ])
        ->using(OrderItem::class)
        ->as('item');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getShippingFirstnameAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return $this->billing_firstname;
    }
}
