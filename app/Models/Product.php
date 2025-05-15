<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'code',
        'description',
        'base_price',
        'selling_price',
        'stock',
        'category_id',
        'image_path',
        'slug',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function billOfMaterial()
    {
        return $this->hasMany(BillOfMaterial::class);
    }

    public function rawMaterial()
    {
        return $this->belongsToMany(RawMaterial::class, 'bill_of_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
