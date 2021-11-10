<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function getCurrentPriceAttribute(): ?float
    {
        return $this->prices
            ->where('from_date', '<=', now())
            ->where('to_date', '>=', now())
            ->first()?->price;
    }
}
