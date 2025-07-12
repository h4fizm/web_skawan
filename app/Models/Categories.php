<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name_category',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_categories', 'id_category', 'id_product');
    }
}
