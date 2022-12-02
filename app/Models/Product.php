<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'barcode', 'cost', 'price', 'stock', 'alert', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class); // 1 producto 1 categoria
    }


}
