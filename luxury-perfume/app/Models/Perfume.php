<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfume extends Model
{
    protected $fillable = [
        'name', 'brand', 'description', 'price', 'image', 'stock', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
