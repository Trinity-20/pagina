<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'stock',
        'sku',
        'barcode',
        'is_featured',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function getMainImageAttribute()
    {
        return $this->images()->where('is_main', true)->first() ?? $this->images()->first();
    }

    // Accesor para la URL de la imagen principal
    public function getMainImageUrlAttribute()
    {
        $mainImage = $this->mainImage;
        if ($mainImage && $mainImage->path) {
            return Storage::url($mainImage->path);
        }
        return null;
    }

    // Generar slug automáticamente
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = \Str::slug($product->name);
            
            // Generar SKU automático si no se proporciona
            if (empty($product->sku)) {
                $product->sku = 'PROD-' . strtoupper(uniqid());
            }
        });

        static::updating(function ($product) {
            $product->slug = \Str::slug($product->name);
        });
    }
}