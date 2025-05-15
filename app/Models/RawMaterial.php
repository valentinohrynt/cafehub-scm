<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    //
    protected $fillable = [
        'name',
        'code',
        'description',
        'stock',
        'unit_price',
        'category_id',
        'supplier_id',
        'image_path',
        'reorder_level',
        'reorder_quantity',
        'lead_time',
        'safety_stock',
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

    public function product()
    {
        return $this->belongsToMany(Product::class, 'bill_of_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
