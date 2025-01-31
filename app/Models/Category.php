<?php

namespace App\Models;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Relasi One-to-Many dengan model Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
