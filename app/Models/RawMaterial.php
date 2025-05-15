<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Models\BillOfMaterial;
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

    protected static function booted()
    {
        static::creating(function ($rawMaterial) {
            $rawMaterial->slug = static::generateUniqueSlug($rawMaterial->name);
        });

        static::updating(function ($rawMaterial) {
            if ($rawMaterial->isDirty('name')) {
                $rawMaterial->slug = static::generateUniqueSlug($rawMaterial->name, $rawMaterial->id);
            }
        });
    }

    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
