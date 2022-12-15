<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    private static $product;
    protected $fillable = [
        'title', 'sku', 'description'
    ];

    public function productVariantPrice()
    {
        return $this->hasOne(ProductVariantPrice::class);
    }

    public function productVariant()
    {
        return $this->hasOne(ProductVariant::class);
    }
    public function productImage()
    {
        return $this->hasOne(ProductImage::class);
    }
//    public function variant()
//    {
//        return $this->hasMany(Variant::class);
//    }
//    public static function createProduct($request)
//    {
//        self::$product = new Product();
//        self::$product->title = $request->title;
//        self::$product->sku = $request->sku;
//        self::$product->description = $request->description;
//        self::$product->save();
//    }
    public static function createOrUpdateProduct($request, $id = null)
    {
        Product::updateOrCreate(['id'=> $id], [
            'title' => $request->title,
            'sku' => $request->sku,
            'description' => $request->description,

        ]);
    }

}
