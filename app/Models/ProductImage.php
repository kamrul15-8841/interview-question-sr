<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

    private static $productImage, $image, $imageUrl, $directory, $imageName,$filePath;
    protected $fillable = [
        'file_path', 'thumbnail'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function uploadImage($request, $product = null)
    {
        self::$image        = $request->file('thumbnail');
        if (self::$image)
        {
            if ($product)
            {
                if (file_exists($product->image))
                {
                    unlink($product->image);
                }
            }
            self::$imageName            = self::$image->getClientOriginalName();
            self::$directory       = 'images/uploaded-files/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl             = self::$directory.self::$imageName;
        } else {
            if ($product)
            {
                self::$imageUrl = $product->image;
            } else {
                self::$imageUrl = null;
            }
        }
        return self::$imageUrl;
    }


    public static function createOrUpdateProductImage($request, $id)
    {
        self::$productImage = ProductImage::find($id);
        if ($request->file('thumbnail'))
        {
            if (file_exists(self::$productImage->image))
            {
                unlink(self::$productImage->image);
            }
            self::$imageUrl = self::uploadImage($request);
        }
        else
        {
            self::$imageUrl = self::$productImage->image;
        }

        self::$productImage = new ProductImage();
        self::$productImage->file_path = self::$directory;
        self::$productImage->thumbnail = self::uploadImage($request);
        self::$productImage->save();

//        ProductImage::updateOrCreate(['id'=> $id=null], [
//            'file_path' => self::uploadImage($request),
////            'thumbnail' => $request->thumbnail,
//            'thumbnail' => self::uploadImage($request),
//        ]);
    }
}

