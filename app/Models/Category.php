<?php

namespace App\Models;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];
    
    // Relasi One-to-Many dengan model Product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category','category_id','product_id');
    }
    
}
