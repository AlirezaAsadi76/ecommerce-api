<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name', 'category_id', 'slug',
        'details', 'price', 'quantity',
        'image', 'images', 'featured',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,);
    }
}
