<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = ['from_date', 'to_date', 'price', 'product_id'];
    protected $dates = ['from_date', 'to_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
