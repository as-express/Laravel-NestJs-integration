<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'count',
        'category_id',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function baskets()
    {
        return $this->belongsToMany(Basket::class, 'basket_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
