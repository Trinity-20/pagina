@php
    $whatsappMessage = rawurlencode("Hola, estoy interesado/a en el producto: {$product->name} (SKU: {$product->sku}). ¿Podrías darme más información?");
    $whatsappLink = "https://wa.me/51980534198?text={$whatsappMessage}";
@endphp

<div class="row">
    <div class="col-md-6">
        <!-- Carousel de imágenes -->
        @if($product->images->count() > 0)
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($product->images as $key => $image)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ Storage::url($image->path) }}" 
                                 class="d-block w-100 rounded" 
                                 alt="{{ $product->name }}"
                                 style="height: 300px; object-fit: contain;">
                        </div>
                    @endforeach
                </div>
                @if($product->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif
            </div>
        @else
            <div class="no-image-placeholder d-flex align-items-center justify-content-center bg-light rounded" 
                 style="height: 300px;">
                <i class="fas fa-image fa-5x text-muted"></i>
            </div>
        @endif
    </div>
    
    <div class="col-md-6">
        <h4>{{ $product->name }}</h4>
        
        @if($product->category)
            <span class="badge bg-info mb-3">
                <i class="fas fa-tag me-1"></i> {{ $product->category->name }}
            </span>
        @endif
        
        <!-- Precio -->
        <div class="mb-3">
            @if($product->compare_price)
                <h5 class="text-danger text-decoration-line-through mb-1">
                    ${{ number_format($product->compare_price, 2) }}
                </h5>
            @endif
            <h3 class="text-primary">${{ number_format($product->price, 2) }}</h3>
        </div>
        
        <!-- Stock -->
        <div class="mb-3">
            @if($product->stock > 10)
                <span class="badge bg-success p-2">
                    <i class="fas fa-check-circle me-1"></i> Disponible ({{ $product->stock }} unidades)
                </span>
            @elseif($product->stock > 0)
                <span class="badge bg-warning p-2">
                    <i class="fas fa-exclamation-triangle me-1"></i> Últimas {{ $product->stock }} unidades
                </span>
            @else
                <span class="badge bg-secondary p-2">
                    <i class="fas fa-times-circle me-1"></i> Agotado
                </span>
            @endif
        </div>
        
        <!-- Descripción -->
        <div class="mb-4">
            <h6>Descripción:</h6>
            <p class="text-muted">{{ $product->description }}</p>
        </div>
        
        <!-- Botones -->
        <div class="d-grid gap-2">
            @if($product->stock > 0)
                <a href="{{ $whatsappLink }}" 
                   class="btn btn-success btn-lg whatsapp-btn" 
                   target="_blank"
                   onclick="trackWhatsAppClick('{{ $product->id }}', '{{ $product->name }}')">
                    <i class="fab fa-whatsapp me-2"></i> ¡Lo quiero! Contactar por WhatsApp
                </a>
            @endif
            
            <button class="btn btn-outline-primary" data-bs-dismiss="modal">
                <i class="fas fa-shopping-cart me-2"></i> Seguir viendo productos
            </button>
        </div>
        
        <!-- Detalles adicionales -->
        <div class="mt-4 pt-4 border-top">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i> SKU: {{ $product->sku ?? 'N/A' }}
            </small>
        </div>
    </div>
</div>