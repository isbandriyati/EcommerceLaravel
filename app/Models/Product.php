<?php

namespace App\Models;

Use App\Models\category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'brand_id',
        'price',
        'prosesor',
        'memory',
        'category_id',
        'stock',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    protected $casts = [
        'prosesor' => 'array', // Agar otomatis dikonversi ke array
        'memory' => 'array',   // Agar otomatis dikonversi ke array
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function brand()
    {
    return $this->belongsTo(Brand::class, 'brand_id');
    }
}
