<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class Cart extends Pivot
{
    use HasFactory;

    protected $table = 'carts';

    protected $keyType = 'string';

    /*protected $with = [
        'product'
    ];*/

    protected static function booted()
    {
        static::creating(function(Cart $cart) {
            $cart->id = Str::uuid();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
