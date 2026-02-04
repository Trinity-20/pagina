@extends('layouts.crud')

@section('title', 'Editar Producto: ' . $product->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Editar Producto</h1>
            <p class="text-muted">{{ $product->name }}</p>
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Volver
            </a>
        </div>
    </div>

    <!-- Formulario -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Información básica -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Información del Producto</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">
                                            Nombre del producto <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $product->name) }}" 
                                               required
                                               placeholder="Ej: iPhone 14 Pro Max">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">
                                            Descripción <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="4"
                                                  required
                                                  placeholder="Describe detalladamente el producto">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Imágenes existentes -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Imágenes Actuales</h5>
                            </div>
                            <div class="card-body">
                                @if($product->images->count() > 0)
                                    <div class="row" id="existingImages">
                                        @foreach($product->images as $image)
                                            <div class="col-md-3 mb-3 existing-image" data-image-id="{{ $image->id }}">
                                                <div class="image-container position-relative {{ $image->is_main ? 'main-image' : '' }}">
                                                    <img src="{{ asset('storage/' . $image->path) }}" 
                                                         class="img-thumbnail w-100" 
                                                         alt="{{ $image->alt_text }}"
                                                         style="height: 150px; object-fit: cover;">
                                                    
                                                    @if($image->is_main)
                                                        <span class="badge bg-success position-absolute top-0 start-0 m-1">
                                                            <i class="fas fa-star me-1"></i> Principal
                                                        </span>
                                                    @endif
                                                    
                                                    <div class="image-actions position-absolute top-0 end-0 m-1">
                                                        @if(!$image->is_main)
                                                            <button type="button" 
                                                                    class="btn btn-primary btn-sm set-main-btn"
                                                                    data-image-id="{{ $image->id }}"
                                                                    title="Establecer como principal">
                                                                <i class="fas fa-star"></i>
                                                            </button>
                                                        @endif
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm delete-image-btn"
                                                                data-image-id="{{ $image->id }}"
                                                                data-image-name="{{ basename($image->path) }}"
                                                                title="Eliminar imagen">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    <!-- Orden de la imagen -->
                                                    <div class="mt-2 text-center">
                                                        <small class="text-muted">Orden: {{ $image->order }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Información sobre las imágenes -->
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Para cambiar el orden de las imágenes, arrástralas y suéltalas en el orden deseado.
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Este producto no tiene imágenes. Puedes agregar imágenes a continuación.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Subida de nuevas imágenes -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Agregar Nuevas Imágenes</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Subir Imágenes</label>
                                    <div class="input-group">
                                        <input type="file" 
                                            class="form-control @error('images.*') is-invalid @enderror" 
                                            id="images" 
                                            name="images[]" 
                                            multiple 
                                            accept="image/jpeg,image/png,image/gif">
                                        <button class="btn btn-outline-secondary" type="button" id="clearImages">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Puedes seleccionar múltiples imágenes. Formatos: JPG, PNG, GIF. Máximo 2MB por imagen
                                    </small>
                                    
                                    @error('images.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Vista previa de nuevas imágenes -->
                                <div id="imagePreviews" class="image-preview-container mt-3"></div>
                                
                                <!-- Contador de imágenes -->
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <span id="imageCount">0</span> nueva(s) imagen(es) seleccionada(s)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar con detalles -->
                    <div class="col-md-4">
                        <!-- Precio y stock -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Precio y Stock</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="price" class="form-label">
                                        Precio de venta <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               step="0.01" 
                                               min="0"
                                               class="form-control @error('price') is-invalid @enderror" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price', $product->price) }}" 
                                               required
                                               placeholder="0.00">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="compare_price" class="form-label">
                                        Precio de comparación
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" 
                                               step="0.01" 
                                               min="0"
                                               class="form-control @error('compare_price') is-invalid @enderror" 
                                               id="compare_price" 
                                               name="compare_price" 
                                               value="{{ old('compare_price', $product->compare_price) }}"
                                               placeholder="0.00">
                                        @error('compare_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Precio tachado para mostrar descuento (opcional)</small>
                                </div>

                                <div class="mb-3">
                                    <label for="stock" class="form-label">
                                        Stock <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           min="0"
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" 
                                           name="stock" 
                                           value="{{ old('stock', $product->stock) }}" 
                                           required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Categoría y estado -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Organización</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Categoría</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" 
                                            name="category_id">
                                        <option value="">Sin categoría</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" 
                                           class="form-control @error('sku') is-invalid @enderror" 
                                           id="sku" 
                                           name="sku" 
                                           value="{{ old('sku', $product->sku) }}"
                                           placeholder="Ej: PROD-001">
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Código de barras</label>
                                    <input type="text" 
                                           class="form-control @error('barcode') is-invalid @enderror" 
                                           id="barcode" 
                                           name="barcode" 
                                           value="{{ old('barcode', $product->barcode) }}"
                                           placeholder="Ej: 123456789012">
                                    @error('barcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Opciones -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Opciones</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           role="switch" 
                                           id="is_featured" 
                                           name="is_featured" 
                                           value="1" 
                                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Producto destacado
                                    </label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           role="switch" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Producto activo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-save me-2"></i> Actualizar Producto
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                                    Cancelar
                                </a>
                                <button type="button" 
                                        class="btn btn-danger w-100" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i> Eliminar Producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
.image-container {
    position: relative;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: move;
}

.image-container.main-image {
    border-color: #0d6efd;
    border-width: 3px;
    background: #e7f1ff;
}

.image-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.image-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-container:hover .image-actions {
    opacity: 1;
}

.image-preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.image-preview {
    position: relative;
    width: 120px;
    height: 120px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 5px;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.image-preview.main-image {
    border-color: #0d6efd;
    border-width: 3px;
    background: #e7f1ff;
}

.image-preview img {
    max-width: 100%;
    max-height: 60px;
    object-fit: contain;
}

.preview-buttons {
    position: absolute;
    bottom: 5px;
    display: flex;
    gap: 5px;
}

.remove-image, .set-main-image {
    padding: 2px 6px;
    font-size: 0.75rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.remove-image:hover {
    background-color: #dc3545;
    color: white;
}

.set-main-image.active {
    background-color: #0d6efd;
    color: white;
}

.set-main-image:not(.active):hover {
    background-color: #6c757d;
    color: white;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    let selectedFiles = [];
    let isProcessing = false;
    
    // Vista previa de nuevas imágenes (mismo código que en create)
    $('#images').on('change', function(e) {
        if (isProcessing) return;
        isProcessing = true;
        
        try {
            const previewContainer = $('#imagePreviews');
            const fileInput = $(this);
            const files = fileInput[0].files;
            
            $('#imageCount').text(files.length);
            previewContainer.empty();
            selectedFiles = Array.from(files);
            
            if (files.length === 0) {
                isProcessing = false;
                return;
            }
            
            let processedCount = 0;
            const totalFiles = files.length;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                if (!file.type.match('image.*')) {
                    processedCount++;
                    continue;
                }
                
                const reader = new FileReader();
                
                reader.onload = (function(index, currentFile) {
                    return function(e) {
                        if ($(`.image-preview[data-index="${index}"]`).length > 0) {
                            processedCount++;
                            checkIfAllProcessed();
                            return;
                        }
                        
                        const previewDiv = $('<div>')
                            .addClass('image-preview')
                            .attr('data-index', index)
                            .attr('data-filename', currentFile.name);
                        
                        const img = $('<img>')
                            .attr('src', e.target.result)
                            .attr('alt', 'Vista previa');
                        
                        const buttonContainer = $('<div>')
                            .addClass('preview-buttons');
                        
                        const removeBtn = $('<button>')
                            .addClass('remove-image btn btn-danger btn-sm')
                            .html('<i class="fas fa-times"></i>')
                            .attr('type', 'button')
                            .attr('title', 'Eliminar imagen')
                            .on('click', function() {
                                removeImage(index);
                            });
                        
                        previewDiv.append(img, buttonContainer);
                        previewContainer.append(previewDiv);
                        
                        processedCount++;
                        checkIfAllProcessed();
                    };
                })(i, file);
                
                reader.readAsDataURL(file);
            }
            
            function checkIfAllProcessed() {
                if (processedCount >= totalFiles) {
                    isProcessing = false;
                }
            }
            
        } catch (error) {
            console.error('Error procesando imágenes:', error);
            isProcessing = false;
        }
    });
    
    // Botón para limpiar nuevas imágenes
    $('#clearImages').on('click', function() {
        $('#images').val('');
        $('#imagePreviews').empty();
        $('#imageCount').text('0');
        selectedFiles = [];
    });
    
    // Eliminar imagen nueva
    function removeImage(index) {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach((file, i) => {
            if (i !== index) {
                dataTransfer.items.add(file);
            }
        });
        
        $('#images')[0].files = dataTransfer.files;
        selectedFiles = Array.from(dataTransfer.files);
        $('#imageCount').text(selectedFiles.length);
        
        const event = new Event('change', { bubbles: true });
        $('#images')[0].dispatchEvent(event);
    }
    
    // Establecer imagen principal existente
    $(document).on('click', '.set-main-btn', function() {
        const imageId = $(this).data('image-id');
        const button = $(this);
        
        if (button.hasClass('disabled')) return;
        
        button.addClass('disabled').html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: '{{ route("products.images.set-main", ":id") }}'.replace(':id', imageId),
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Actualizar interfaz
                    $('.existing-image .badge.bg-success').remove();
                    $('.existing-image').removeClass('main-image');
                    $('.set-main-btn').show();
                    
                    // Marcar nueva imagen principal
                    const container = button.closest('.existing-image');
                    container.addClass('main-image');
                    container.find('.image-container').prepend(
                        '<span class="badge bg-success position-absolute top-0 start-0 m-1">' +
                        '<i class="fas fa-star me-1"></i> Principal</span>'
                    );
                    button.hide();
                    
                    // Mostrar mensaje
                    showAlert('success', response.message);
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.message || 'Error al establecer imagen principal';
                showAlert('danger', error);
            },
            complete: function() {
                button.removeClass('disabled').html('<i class="fas fa-star"></i>');
            }
        });
    });
    
    // Eliminar imagen existente
    $(document).on('click', '.delete-image-btn', function() {
        const imageId = $(this).data('image-id');
        const imageName = $(this).data('image-name');
        const button = $(this);
        
        if (!confirm(`¿Estás seguro de que deseas eliminar la imagen "${imageName}"?`)) {
            return;
        }
        
        button.addClass('disabled').html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: '{{ route("products.images.destroy", ":id") }}'.replace(':id', imageId),
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Eliminar elemento del DOM
                    button.closest('.existing-image').remove();
                    
                    // Verificar si quedan imágenes
                    if ($('#existingImages .existing-image').length === 0) {
                        $('#existingImages').html(
                            '<div class="alert alert-warning w-100">' +
                            '<i class="fas fa-exclamation-triangle me-2"></i>' +
                            'Este producto no tiene imágenes.' +
                            '</div>'
                        );
                    }
                    
                    showAlert('success', response.message);
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.message || 'Error al eliminar la imagen';
                showAlert('danger', error);
            },
            complete: function() {
                button.removeClass('disabled').html('<i class="fas fa-trash"></i>');
            }
        });
    });
    
    // Ordenar imágenes con drag and drop
    const sortable = Sortable.create(document.getElementById('existingImages'), {
        animation: 150,
        handle: '.image-container',
        onEnd: function(evt) {
            const imageIds = Array.from(evt.to.children).map(child => {
                return $(child).data('image-id');
            });
            
            // Actualizar orden en el servidor (opcional)
            updateImageOrder(imageIds);
        }
    });
    
    function updateImageOrder(imageIds) {
        $.ajax({
            url: '{{ route("products.update-image-order", $product) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                image_ids: imageIds
            }
        });
    }
    
    function showAlert(type, message) {
        const alert = $('<div>')
            .addClass(`alert alert-${type} alert-dismissible fade show`)
            .attr('role', 'alert')
            .html(`
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `);
        
        $('.container-fluid').prepend(alert);
        
        setTimeout(() => {
            alert.alert('close');
        }, 5000);
    }
    
    // Validación del formulario
    $('#productForm').on('submit', function(e) {
        const name = $('#name').val().trim();
        const price = parseFloat($('#price').val());
        const stock = parseInt($('#stock').val());
        
        if (!name) {
            e.preventDefault();
            showAlert('danger', 'El nombre del producto es requerido');
            $('#name').focus();
            return;
        }
        
        if (isNaN(price) || price < 0) {
            e.preventDefault();
            showAlert('danger', 'El precio debe ser un número positivo');
            $('#price').focus();
            return;
        }
        
        if (isNaN(stock) || stock < 0) {
            e.preventDefault();
            showAlert('danger', 'El stock debe ser un número positivo');
            $('#stock').focus();
            return;
        }
    });
});
</script>
@endpush
@endsection