<?php

namespace App\Models;

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
        'prosesor' => 'array',
        'memory' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class); // Ini sudah benar untuk one-to-many
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class); // Ini juga sudah benar
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['brands'])) {
            $query->whereIn('brand_id', $filters['brands']);
        }

        return $query;
    }

    public function cart()
{
    return $this->belongsToMany(Cart::class)->withPivot('quantity');
}

    
}