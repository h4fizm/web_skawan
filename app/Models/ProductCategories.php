<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    protected $table = 'product_categories';
    protected $fillable = [
        'id_product',
        'id_category',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'id_product');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'id_category');
    }
}
