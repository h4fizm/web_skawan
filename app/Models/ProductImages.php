<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
        'id_product',
        'image_path',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'id_product');
    }
}
