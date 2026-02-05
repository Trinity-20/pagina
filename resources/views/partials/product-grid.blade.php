@foreach($products as $product)
    @php
        // No uses 'use' aquí, llama directamente a las clases con su namespace completo
        $mainImage = $product->images->firstWhere('is_main') ?? $product->images->first();
        $hasDiscount = $product->compare_price > $product->price;
        $discountPercentage = $hasDiscount 
            ? round((($product->compare_price - $product->price) / $product->compare_price) * 100) 
            : 0;
        
        // Configurar mensaje de WhatsApp
        $whatsappMessage = rawurlencode("✨ ¡Hola! Me encantó el producto: {$product->name} ✨ (SKU: {$product->sku}). ¿Podrías darme más información? ¡Estoy super emocionado/a! 🎉");
        $whatsappLink = "https://wa.me/51900456625?text={$whatsappMessage}";
        
        // Preparar datos de imágenes de manera segura
        $imagesData = $product->images->map(function($image) {
            return [
                // Usa el facade Storage directamente
                'url' => \Illuminate\Support\Facades\Storage::url($image->path),
                'alt' => $image->alt_text
            ];
        });
    @endphp
    
    <div class="col-md-4 col-lg-4 col-xl-4 mb-3">
        <div class="product-card">
            <!-- Badges -->
            @if($hasDiscount)
                <span class="product-badge badge-discount">-{{ $discountPercentage }}%</span>
            @endif
            @if($product->is_featured)
                <span class="product-badge badge-featured">Destacado</span>
            @endif
            
            <!-- Icono de vista de imágenes -->
            <div class="product-view-icon" 
                onclick="openImageModal({{ $product->id }}, {{ $imagesData->toJson() }})"
                title="Ver todas las imágenes">
                <i class="fas fa-eye"></i>
            </div>
            
            <!-- Imagen del producto -->
            <div class="product-image-container">
                @if($mainImage)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($mainImage->path) }}" 
                         class="product-image" 
                         alt="{{ $product->name }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-gem"></i>
                    </div>
                @endif
            </div>
            
            <!-- Precio siempre visible -->
            <div class="product-price">
                ${{ number_format($product->price, 2) }}
            </div>
            
            <!-- Overlay al hacer hover -->
            <div class="product-overlay">
                <h3 class="product-name">{{ \Illuminate\Support\Str::limit($product->name, 40) }}</h3>
                <p class="product-description">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 120) }}</p>
                
                @if($hasDiscount)
                    <div class="mb-3">
                        <small class="text-white-50 text-decoration-line-through me-2">
                            ${{ number_format($product->compare_price, 2) }}
                        </small>
                        <span class="fs-4 fw-bold text-warning">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>
                @else
                    <div class="fs-4 fw-bold text-warning mb-3">
                        ${{ number_format($product->price, 2) }}
                    </div>
                @endif
                
                @if($product->stock > 0)
                    <a href="{{ $whatsappLink }}" 
                       class="whatsapp-btn" 
                       target="_blank"
                       onclick="event.stopPropagation(); trackWhatsAppClick('{{ $product->id }}', '{{ $product->name }}')">
                        <i class="fab fa-whatsapp me-2"></i> Agregar
                    </a>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>
                        <i class="fas fa-ban me-2"></i> Agotado
                    </button>
                @endif
            </div>
        </div>
    </div>
@endforeach