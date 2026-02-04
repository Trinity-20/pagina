@extends('layouts.crud')

@section('title', 'Nuevo Producto')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Nuevo Producto</h1>
            <p class="text-muted">Agrega un nuevo producto al catálogo</p>
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
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf

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
                                               value="{{ old('name') }}" 
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
                                                  placeholder="Describe detalladamente el producto">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subida de imágenes -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Imágenes del Producto</h5>
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
                                        Puedes seleccionar múltiples imágenes. Formatos: JPG, PNG, GIF. Máximo 2MB por imagen. 
                                        <strong>La primera imagen será la principal por defecto</strong>
                                    </small>
                                    
                                    @error('images.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Vista previa de imágenes -->
                                <div id="imagePreviews" class="image-preview-container mt-3"></div>
                                
                                <!-- Contador de imágenes -->
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <span id="imageCount">0</span> imagen(es) seleccionada(s)
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
                                               value="{{ old('price') }}" 
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
                                               value="{{ old('compare_price') }}"
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
                                           value="{{ old('stock', 0) }}" 
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
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                           value="{{ old('sku') }}"
                                           placeholder="Ej: PROD-001">
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Dejar en blanco para generar automáticamente</small>
                                </div>

                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Código de barras</label>
                                    <input type="text" 
                                           class="form-control @error('barcode') is-invalid @enderror" 
                                           id="barcode" 
                                           name="barcode" 
                                           value="{{ old('barcode') }}"
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
                                           {{ old('is_featured') ? 'checked' : '' }}>
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
                                           {{ old('is_active', true) ? 'checked' : '' }}>
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
                                    <i class="fas fa-save me-2"></i> Guardar Producto
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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

@push('scripts')
<script>
    $(document).ready(function() {
        let selectedFiles = [];
        let isProcessing = false; // Bandera para evitar procesamiento duplicado
        
        // Deshabilitar completamente Dropzone si existe
        if (typeof Dropzone !== 'undefined') {
            Dropzone.autoDiscover = false;
            // Deshabilitar todas las instancias de Dropzone
            Dropzone.instances.forEach(function(dz) {
                dz.disable();
            });
            // Remover clases dropzone
            $('.dropzone').removeClass('dropzone').removeAttr('id');
        }
        
        // Vista previa de imágenes seleccionadas - VERSIÓN MEJORADA
        $('#images').on('change', function(e) {
            // Si ya está procesando, salir
            if (isProcessing) {
                console.log('Ya se está procesando, ignorando cambio...');
                return;
            }
            
            isProcessing = true;
            
            try {
                const previewContainer = $('#imagePreviews');
                const fileInput = $(this);
                const files = fileInput[0].files;
                
                console.log('Archivos seleccionados:', files.length);
                
                // Actualizar contador
                $('#imageCount').text(files.length);
                
                // Limpiar vista previa anterior completamente
                previewContainer.empty();
                
                // Guardar archivos seleccionados
                selectedFiles = Array.from(files);
                
                // Si no hay archivos, terminar
                if (files.length === 0) {
                    isProcessing = false;
                    return;
                }
                
                // Contador para saber cuántas imágenes se procesaron
                let processedCount = 0;
                const totalFiles = files.length;
                
                // Crear vista previa para cada imagen
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    // Validar tipo de archivo
                    if (!file.type.match('image.*')) {
                        console.log('Archivo no es imagen:', file.name);
                        processedCount++;
                        continue;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.onload = (function(index, currentFile) {
                        return function(e) {
                            // Verificar si este índice ya fue procesado
                            if ($(`.image-preview[data-index="${index}"]`).length > 0) {
                                console.log('Índice ya procesado:', index);
                                processedCount++;
                                checkIfAllProcessed();
                                return;
                            }
                            
                            // Crear elemento de vista previa
                            const previewDiv = $('<div>')
                                .addClass('image-preview')
                                .attr('data-index', index)
                                .attr('data-filename', currentFile.name);
                            
                            // Crear imagen
                            const img = $('<img>')
                                .attr('src', e.target.result)
                                .attr('alt', 'Vista previa');
                            
                            // Contenedor para botones
                            const buttonContainer = $('<div>')
                                .addClass('preview-buttons');
                            
                            // Crear botón de eliminar
                            const removeBtn = $('<button>')
                                .addClass('remove-image btn btn-danger btn-sm')
                                .html('<i class="fas fa-times"></i>')
                                .attr('type', 'button')
                                .attr('title', 'Eliminar imagen')
                                .on('click', function() {
                                    removeImage(index);
                                });
                            
                            // Crear botón para marcar como principal (solo si es la primera imagen)
                            const mainBtn = $('<button>')
                                .addClass('set-main-image btn btn-primary btn-sm')
                                .html('<i class="fas fa-star"></i> Principal')
                                .attr('type', 'button')
                                .attr('title', 'Establecer como imagen principal')
                                .attr('data-index', index)
                                .on('click', function() {
                                    setMainImage(index);
                                });
                            
                            // Si es la primera imagen, marcarla como principal por defecto
                            if (index === 0) {
                                mainBtn.addClass('active').html('<i class="fas fa-star"></i> Principal');
                                previewDiv.addClass('main-image');
                                // Agregar indicador visual
                                const mainBadge = $('<span>')
                                    .addClass('badge bg-success position-absolute top-0 start-0 m-1')
                                    .text('Principal')
                                    .css({
                                        'z-index': '10',
                                        'font-size': '0.7rem'
                                    });
                                previewDiv.append(mainBadge);
                            }
                            
                            // Crear radio button oculto para el formulario
                            const radioInput = $('<input>')
                                .attr('type', 'radio')
                                .attr('name', 'main_image_index')
                                .attr('id', `main_image_${index}`)
                                .attr('value', index)
                                .addClass('d-none')
                                .prop('checked', index === 0);
                            
                            buttonContainer.append(removeBtn, mainBtn);
                            
                            // Crear información del archivo
                            const nameSpan = $('<small>')
                                .addClass('d-block mt-1 text-truncate')
                                .css('max-width', '100px')
                                .text(currentFile.name);
                            
                            const sizeSpan = $('<small>')
                                .addClass('d-block text-muted')
                                .text(formatBytes(currentFile.size));
                            
                            // Ensamblar vista previa
                            previewDiv.append(img, buttonContainer, radioInput, nameSpan, sizeSpan);
                            
                            // Agregar al contenedor
                            previewContainer.append(previewDiv);
                            
                            processedCount++;
                            checkIfAllProcessed();
                        };
                    })(i, file);
                    
                    reader.readAsDataURL(file);
                }
                
                // Función para verificar si todas las imágenes fueron procesadas
                function checkIfAllProcessed() {
                    if (processedCount >= totalFiles) {
                        console.log('Procesamiento completado. Total procesado:', processedCount);
                        isProcessing = false;
                    }
                }
                
            } catch (error) {
                console.error('Error procesando imágenes:', error);
                isProcessing = false;
            }
        });
        
        // Botón para limpiar todas las imágenes
        $('#clearImages').on('click', function() {
            $('#images').val('');
            $('#imagePreviews').empty();
            $('#imageCount').text('0');
            selectedFiles = [];
        });
        
        // Función para formatear bytes a tamaño legible
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
        
        // Función para eliminar una imagen específica
        function removeImage(index) {
            // Crear un nuevo DataTransfer
            const dataTransfer = new DataTransfer();
            
            // Agregar todos los archivos excepto el que se va a eliminar
            selectedFiles.forEach((file, i) => {
                if (i !== index) {
                    dataTransfer.items.add(file);
                }
            });
            
            // Actualizar el input file
            $('#images')[0].files = dataTransfer.files;
            
            // Actualizar el array de archivos
            selectedFiles = Array.from(dataTransfer.files);
            
            // Actualizar contador
            $('#imageCount').text(selectedFiles.length);
            
            // Forzar un nuevo evento change para regenerar vista previa
            const event = new Event('change', { bubbles: true });
            $('#images')[0].dispatchEvent(event);
        }
        
        // Función para establecer imagen principal
        function setMainImage(index) {
            // Quitar clase activa de todos los botones
            $('.set-main-image').removeClass('active').html('<i class="fas fa-star"></i> Principal');
            
            // Quitar clase main-image de todas las imágenes
            $('.image-preview').removeClass('main-image');
            
            // Remover todas las badges de "Principal"
            $('.image-preview .badge.bg-success').remove();
            
            // Agregar clase activa al botón seleccionado
            $(`.set-main-image[data-index="${index}"]`)
                .addClass('active')
                .html('<i class="fas fa-star"></i> Principal');
            
            // Agregar clase main-image a la imagen seleccionada
            $(`.image-preview[data-index="${index}"]`).addClass('main-image');
            
            // Agregar indicador visual de "Principal"
            const mainBadge = $('<span>')
                .addClass('badge bg-success position-absolute top-0 start-0 m-1')
                .text('Principal')
                .css({
                    'z-index': '10',
                    'font-size': '0.7rem'
                });
            
            $(`.image-preview[data-index="${index}"]`).append(mainBadge);
            
            // Actualizar radio button
            $(`#main_image_${index}`).prop('checked', true);
        }

        // Función para actualizar la vista cuando se elimina una imagen
        function updateMainImageAfterRemoval() {
            // Si no hay imágenes, salir
            if (selectedFiles.length === 0) return;
            
            // Verificar si alguna imagen está marcada como principal
            const hasMainImage = $('.set-main-image.active').length > 0;
            
            // Si no hay imagen principal, establecer la primera como principal
            if (!hasMainImage) {
                const firstIndex = $('.image-preview').first().data('index');
                if (firstIndex !== undefined) {
                    setMainImage(firstIndex);
                }
            }
        }

        // Modificar la función removeImage para llamar a updateMainImageAfterRemoval
        function removeImage(index) {
            // Crear un nuevo DataTransfer
            const dataTransfer = new DataTransfer();
            
            // Agregar todos los archivos excepto el que se va a eliminar
            selectedFiles.forEach((file, i) => {
                if (i !== index) {
                    dataTransfer.items.add(file);
                }
            });
            
            // Actualizar el input file
            $('#images')[0].files = dataTransfer.files;
            
            // Actualizar el array de archivos
            selectedFiles = Array.from(dataTransfer.files);
            
            // Actualizar contador
            $('#imageCount').text(selectedFiles.length);
            
            // Actualizar imagen principal si es necesario
            updateMainImageAfterRemoval();
            
            // Forzar un nuevo evento change para regenerar vista previa
            const event = new Event('change', { bubbles: true });
            $('#images')[0].dispatchEvent(event);
        }

        // Exponer la función globalmente
        window.removeImage = removeImage;
        
        // Validación del formulario
        $('#productForm').on('submit', function(e) {
            // ... (código de validación permanece igual) ...
        });
    });
</script>
@endpush
@endsection
