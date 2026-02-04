@extends('layouts.crud')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detalles del Producto</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Editar
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Columna izquierda - Imágenes -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Imágenes del Producto</h5>
                </div>
                <div class="card-body">
                    @if($product->images->count() > 0)
                        <!-- Imagen principal -->
                        <div class="text-center mb-4">
                            @if($product->mainImage)
                                <img src="{{ asset('storage/' . $product->mainImage->path) }}" 
                                     class="img-fluid rounded" 
                                     alt="{{ $product->mainImage->alt_text }}"
                                     id="mainImage"
                                     style="max-height: 400px; object-fit: contain;">
                            @endif
                        </div>
                        
                        <!-- Galería de miniaturas -->
                        @if($product->images->count() > 1)
                            <div class="row g-2" id="imageGallery">
                                @foreach($product->images as $image)
                                    <div class="col-3">
                                        <div class="image-thumbnail {{ $image->is_main ? 'active' : '' }}"
                                             data-image-src="{{ asset('storage/' . $image->path) }}"
                                             data-image-alt="{{ $image->alt_text }}">
                                            <img src="{{ asset('storage/' . $image->path) }}" 
                                                 class="img-fluid rounded" 
                                                 alt="{{ $image->alt_text }}"
                                                 style="height: 80px; width: 100%; object-fit: cover; cursor: pointer;">
                                            @if($image->is_main)
                                                <span class="badge bg-success position-absolute top-0 start-0 m-1">
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Información de imágenes -->
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-images me-1"></i>
                                {{ $product->images->count() }} {{ Str::plural('imagen', $product->images->count()) }}
                            </small>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Este producto no tiene imágenes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Columna derecha - Información -->
        <div class="col-lg-7">
            <!-- Información básica -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información del Producto</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h2 class="h4">{{ $product->name }}</h2>
                            @if($product->category)
                                <span class="badge bg-info">
                                    <i class="fas fa-tag me-1"></i> {{ $product->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end">
                            <!-- Estados -->
                            <div class="d-flex gap-2 justify-content-md-end">
                                @if($product->is_featured)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-star me-1"></i> Destacado
                                    </span>
                                @endif
                                
                                @if($product->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Activo
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i> Inactivo
                                    </span>
                                @endif
                                
                                @if($product->trashed())
                                    <span class="badge bg-dark">
                                        <i class="fas fa-trash me-1"></i> Eliminado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Descripción</h6>
                        <p class="mb-0">{{ $product->description }}</p>
                    </div>
                    
                    <hr>
                    
                    <!-- Precios -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Precio de venta</h6>
                            <h3 class="text-primary">${{ number_format($product->price, 2) }}</h3>
                        </div>
                        @if($product->compare_price)
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Precio de comparación</h6>
                                <h4 class="text-danger text-decoration-line-through">
                                    ${{ number_format($product->compare_price, 2) }}
                                </h4>
                                @php
                                    $discount = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                                @endphp
                                <span class="badge bg-danger">Ahorra {{ $discount }}%</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Stock y códigos -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Stock disponible</h6>
                            <div class="d-flex align-items-center">
                                @if($product->stock > 10)
                                    <span class="badge bg-success me-2">{{ $product->stock }} unidades</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning me-2">{{ $product->stock }} unidades</span>
                                @else
                                    <span class="badge bg-danger me-2">Agotado</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">SKU</h6>
                            <p class="mb-0"><code>{{ $product->sku ?? 'No asignado' }}</code></p>
                        </div>
                        
                        @if($product->barcode)
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-2">Código de barras</h6>
                                <p class="mb-0"><code>{{ $product->barcode }}</code></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="row">
                <!-- Metadatos -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="mb-0">Información Adicional</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-hashtag text-muted me-2"></i>
                                    <strong>ID:</strong> {{ $product->id }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-link text-muted me-2"></i>
                                    <strong>Slug:</strong> {{ $product->slug }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-calendar-plus text-muted me-2"></i>
                                    <strong>Creado:</strong> {{ $product->created_at->format('d/m/Y H:i') }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-calendar-check text-muted me-2"></i>
                                    <strong>Actualizado:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}
                                </li>
                                @if($product->trashed())
                                    <li class="mb-2">
                                        <i class="fas fa-calendar-times text-muted me-2"></i>
                                        <strong>Eliminado:</strong> {{ $product->deleted_at->format('d/m/Y H:i') }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones rápidas -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6 class="mb-0">Acciones Rápidas</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if(!$product->trashed())
                                    <!-- Toggle estado activo -->
                                    <form action="{{ route('products.toggle-status', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-{{ $product->is_active ? 'warning' : 'success' }} w-100">
                                            <i class="fas fa-power-off me-2"></i>
                                            {{ $product->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                    
                                    <!-- Toggle destacado -->
                                    <form action="{{ route('products.toggle-featured', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-{{ $product->is_featured ? 'secondary' : 'warning' }} w-100">
                                            <i class="fas fa-star me-2"></i>
                                            {{ $product->is_featured ? 'Quitar destacado' : 'Destacar' }}
                                        </button>
                                    </form>
                                    
                                    <!-- Eliminar -->
                                    <button type="button" 
                                            class="btn btn-outline-danger w-100" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal">
                                        <i class="fas fa-trash me-2"></i> Eliminar Producto
                                    </button>
                                @else
                                    <!-- Restaurar producto eliminado -->
                                    <form action="{{ route('products.restore', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-trash-restore me-2"></i> Restaurar Producto
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar el producto <strong>{{ $product->name }}</strong>?</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Esta acción no se puede deshacer. Todas las imágenes asociadas también serán eliminadas.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.image-thumbnail {
    position: relative;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    padding: 2px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.image-thumbnail:hover {
    border-color: #0d6efd;
    transform: scale(1.05);
}

.image-thumbnail.active {
    border-color: #0d6efd;
    border-width: 3px;
}

.badge {
    font-size: 0.75em;
    padding: 0.25em 0.5em;
}

.list-unstyled li {
    padding: 0.25rem 0;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Cambiar imagen principal al hacer clic en miniatura
    $('.image-thumbnail').on('click', function() {
        const imageSrc = $(this).data('image-src');
        const imageAlt = $(this).data('image-alt');
        
        // Actualizar imagen principal
        $('#mainImage').attr('src', imageSrc).attr('alt', imageAlt);
        
        // Actualizar miniatura activa
        $('.image-thumbnail').removeClass('active');
        $(this).addClass('active');
    });
    
    // Confirmación para acciones
    $('form[method="POST"]').on('submit', function(e) {
        const button = $(this).find('button[type="submit"]');
        const action = button.text().trim().toLowerCase();
        
        if (action.includes('eliminar') || action.includes('desactivar') || action.includes('activar')) {
            const message = action.includes('eliminar') 
                ? '¿Estás seguro de que deseas eliminar este producto?'
                : `¿Estás seguro de que deseas ${action} este producto?`;
            
            if (!confirm(message)) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endpush
@endsection