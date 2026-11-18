<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'description_short',
        'description_long',
        'price_mx',
        'price_usd',
        'image_url',
        'validity_at',
        'is_active',
        'stock',
        'slug',
        'sku'
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $base = Str::slug($product->name);
            $slug = $base;
            $number = 2;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$base}-{$number}";
                $number++;
            }

            $product->slug = $slug;
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
