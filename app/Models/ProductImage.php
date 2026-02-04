<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'alt_text',
        'order',
        'is_main'
    ];

    protected $casts = [
        'is_main' => 'boolean'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // URL completa de la imagen
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    // Ruta completa del archivo
    public function getFilePathAttribute()
    {
        return storage_path('app/public/' . $this->path);
    }

    // Establecer como imagen principal
    public function setAsMain()
    {
        // Quitar el estado de principal de otras imágenes
        $this->product->images()->update(['is_main' => false]);
        
        // Establecer esta como principal
        $this->update(['is_main' => true]);
    }
}