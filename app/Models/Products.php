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
        return $this->hasMany(ProductCategories::class, 'id_product');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImages::class, 'id_product');
    }
}
