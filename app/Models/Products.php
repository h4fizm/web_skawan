<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name_product',
        'total_stock',
        'price',
        'description',
        'information',
    ];

    public function productCategories()
    {
        return $this->belongsToMany(ProductCategories::class, 'product_categories', 'id_product', 'id_category');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImages::class, 'id_product');
    }
}
