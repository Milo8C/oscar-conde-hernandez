<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    //
    protected $fillable = [
        'customer_id',
        'order_code',
        'subtotal',
        'total',
        'iva',
        'status',
        'slug',
        'paid_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public static function generateOrderCode()
    {
        $latestId = static::max('id') ?? 0;
        $sequence = $latestId + 1;

        do {
            $code = 'ORD-' . date('Ymd') . '-' . str_pad($sequence, 6, '0', STR_PAD_LEFT);
            $sequence++;
        } while (static::where('order_code', $code)->exists());

        return $code;
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $base = Str::slug($order->order_code);
            $slug = $base;
            $number = 2;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$base}-{$number}";
                $number++;
            }

            $order->slug = $slug;
        });
        // static::updating(function (Product $product) {
        //     $base = Str::slug($product->name);
        //     $slug = $base;
        //     $number = 2;

        //     while (static::where('slug', $slug)->exists()) {
        //         $slug = "{$base}-{$number}";
        //         $number++;
        //     }

        //     $product->slug = $slug;
        // });
    }
}
