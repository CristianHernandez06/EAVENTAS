<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name', 'image'];

    //relacion de la tabla categoria con la tabla productos
    public function products(){
        return $this->hasMany(Product::class); // una categoria puede tener muchos productos..
    }
}
