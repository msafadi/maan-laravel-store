<?php

namespace App\Models;

use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForMail($notification = null)
    {
        /*if ($notification instanceof NewOrderNotification) {
            return $this->email_address;
        }*/
        return $this->email;
    }

    public function routeNotificationForNexmo($notification = null)
    {
        return $this->mobile;
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'Notifications.' . $this->id;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function cartProducts()
    {
        return $this->belongsToMany(
            Product::class, 'carts'
        )
        ->using(Cart::class)
        ->withPivot([
            'id', 'cookie_id', 'quantity',
        ])
        ->as('cart');
    }
}
