<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    public function productVariant()
    {
        return $this->hasMany(ProductVariant::class);
    }
//    public function product()
//    {
//        return $this->hasMany(Product::class);
//    }

}
