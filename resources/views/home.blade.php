@extends('layouts.app')

@section('title', 'Moonlight ✨ - Pulseras que iluminan tu estilo')

@push('styles')
<style>
    /* Fondo morado completo */
    body {
        background: linear-gradient(135deg, #48117d 0%, #3d1e7b 100%) !important;
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Header */
    .moonlight-header {
        padding: 40px 0 30px 0;
        text-align: center;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 40px;
    }

    .moonlight-title {
        font-size: 3.2rem;
        font-weight: 700;
        color: white;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .moonlight-title i {
        color: #ffd700;
        margin-right: 10px;
    }

    .moonlight-subtitle {
        font-size: 1.4rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 25px;
        font-weight: 300;
    }

    /* Botón de filtro */
    .filter-btn {
        background: rgba(255, 255, 255, 0.9);
        color: #8a2be2;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .filter-btn:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    /* Contenedor principal */
    .main-content {
        padding-bottom: 50px;
    }

    /* Grid de productos */
    .products-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Tarjeta de producto */
    .product-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        height: 350px;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    /* Imagen del producto */
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* Precio siempre visible */
    .product-price {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.95);
        color: #8a2be2;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 1.3rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(138, 43, 226, 0.3);
        z-index: 3;
        border: 2px solid #8a2be2;
    }

    /* Overlay al hacer hover */
    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(138, 43, 226, 0.9), rgba(147, 112, 219, 0.95));
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px;
        opacity: 0;
        transition: opacity 0.3s ease;
        text-align: center;
        color: white;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    /* Contenido del overlay */
    .product-name {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: white;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }

    .product-description {
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.9);
        max-height: 80px;
        overflow: hidden;
    }

    /* Botón de WhatsApp en overlay */
    .whatsapp-btn {
        background: #25D366;
        color: white;
        border: none;
        padding: 12px 35px;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
    }

    .whatsapp-btn:hover {
        background: #128C7E;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        color: white;
    }

    /* Badges */
    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 4;
    }

    .badge-discount {
        background: #ff4757;
        color: white;
    }

    .badge-featured {
        background: #ffa502;
        color: white;
        top: 55px;
    }

    /* Paginación */
    .pagination .page-link {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        margin: 0 5px;
        border-radius: 10px;
    }

    .pagination .page-item.active .page-link {
        background: white;
        color: #8a2be2;
        border-color: white;
    }

    .pagination .page-link:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Sin imagen placeholder */
    .no-image {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #8a2be2, #9370db);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
    }

    /* Responsive */
    @media (max-width: 1400px) {
        .product-card {
            height: 320px;
        }
    }

    @media (max-width: 1200px) {
        .product-card {
            height: 300px;
        }
    }

    @media (max-width: 992px) {
        .product-card {
            height: 350px;
        }
        
        .row > .col-md-4 {
            width: 50%;
        }
    }

    @media (max-width: 768px) {
        .moonlight-title {
            font-size: 2.5rem;
        }
        
        .moonlight-subtitle {
            font-size: 1.1rem;
        }
        
        .product-card {
            height: 400px;
            margin-bottom: 20px;
        }
        
        .row > .col-md-4 {
            width: 100%;
        }
        
        .product-overlay {
            padding: 20px;
        }
        
        .product-name {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 576px) {
        .product-card {
            height: 350px;
        }
        
        .filter-btn {
            padding: 10px 25px;
            font-size: 1rem;
        }
        
        .products-container {
            padding: 0 15px;
        }
    }


    /* Icono de ojo para ver imágenes */
    .product-view-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8a2be2;
        font-size: 1.2rem;
        opacity: 0;
        transition: all 0.3s ease;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .product-card:hover .product-view-icon {
        opacity: 1;
        transform: scale(1.1);
    }

    .product-view-icon:hover {
        background: white;
        transform: scale(1.2) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    /* Modal para imágenes (simplificado) */
    .image-modal .modal-dialog {
        max-width: 90vw;
        max-height: 90vh;
        margin: 5vh auto;
    }

    .image-modal .modal-content {
        background: rgba(0, 0, 0, 0.8);
        border: none;
        border-radius: 10px;
    }

    .image-modal .modal-body {
        padding: 0;
        position: relative;
    }

    /* Imagen principal */
    .modal-main-image {
        width: 100%;
        height: 80vh;
        object-fit: contain;
        border-radius: 10px;
    }

    /* Flechas de navegación */
    .image-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #8a2be2;
        transition: all 0.3s ease;
        z-index: 100;
    }

    .image-nav-btn:hover {
        background: white;
        transform: translateY(-50%) scale(1.1);
    }

    .image-prev-btn {
        left: 20px;
    }

    .image-next-btn {
        right: 20px;
    }

    /* Botón cerrar */
    .image-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.7);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 1.2rem;
        z-index: 100;
        transition: all 0.3s ease;
    }

    .image-close-btn:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.1);
    }

    /* FIX CRÍTICO: El overlay está bloqueando el icono */
    .product-overlay {
        pointer-events: none; /* Permite que los clics pasen a través */
    }

    .product-card:hover .product-overlay {
        opacity: 1;
        pointer-events: auto; /* Solo permite clics cuando es visible */
    }

    /* El icono del ojo debe estar siempre accesible */
    .product-view-icon {
        pointer-events: auto !important;
        z-index: 1000 !important;
    }

    /* Asegurar que el contenedor de imagen exista */
    .product-image-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .product-overlay {
        pointer-events: none; /* Permite clics a través del overlay */
    }

    /* El icono del ojo debe tener prioridad */
    .product-view-icon {
        pointer-events: auto !important;
        z-index: 1000 !important;
        cursor: pointer;
    }

    /* Cuando el overlay está visible */
    .product-card:hover .product-overlay {
        opacity: 1;
        pointer-events: auto; /* Solo cuando es visible */
    }

    /* Asegurar que el contenedor no bloquee */
    .product-card {
        position: relative;
        overflow: visible !important;
    }
</style>
@endpush

@section('content')
    <!-- El header ya está incluido en el layout -->

    <!-- Productos -->
    <div class="products-container">
        <div class="row g-4" id="productos">
            @include('partials.product-grid')
        </div>

        <!-- Paginación -->
        @if($products->hasPages())
        <div class="mt-5">
            <nav>
                <ul class="pagination justify-content-center" id="pagination">
                    {{ $products->links() }}
                </ul>
            </nav>
        </div>
        @endif
    </div>



<!-- Modal para ver imágenes -->
<div class="modal fade image-modal" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-body p-0 position-relative">
                <!-- Botón cerrar -->
                <button type="button" class="btn-close btn-close-white position-absolute" 
                        style="top: 15px; right: 15px; z-index: 1050; background: rgba(0,0,0,0.5);"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                
                <!-- Contenedor de imagen -->
                <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh; position: relative;">
                    <!-- Flecha izquierda (solo visible cuando hay más de 1 imagen) -->
                    <button class="btn btn-dark rounded-circle p-3 position-absolute start-0 ms-3" 
                            id="prevImageBtn"
                            style="display: none; z-index: 1000; background: rgba(0,0,0,0.7);">
                        <i class="fas fa-chevron-left fa-2x"></i>
                    </button>
                    
                    <!-- Imagen principal -->
                    <img id="modalMainImage" class="img-fluid" 
                         src="" alt=""
                         style="max-height: 70vh; object-fit: contain; border-radius: 5px;">
                    
                    <!-- Flecha derecha (solo visible cuando hay más de 1 imagen) -->
                    <button class="btn btn-dark rounded-circle p-3 position-absolute end-0 me-3" 
                            id="nextImageBtn"
                            style="display: none; z-index: 1000; background: rgba(0,0,0,0.7);">
                        <i class="fas fa-chevron-right fa-2x"></i>
                    </button>
                </div>
                
                <!-- Indicadores de imágenes (puntos) -->
                <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3">
                    <div class="d-flex gap-2" id="imageIndicators">
                        <!-- Se llenará dinámicamente con JavaScript -->
                    </div>
                </div>
                
                <!-- Contador de imágenes -->
                <div class="position-absolute top-0 start-50 translate-middle-x mt-3">
                    <span id="imageCounter" class="badge bg-secondary fs-6 px-3 py-2"
                          style="background: rgba(0,0,0,0.7) !important;">
                        <!-- Se llenará dinámicamente -->
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection

@push('scripts')
<script>
    // Número de WhatsApp (cambia esto por tu número real)
    const whatsappNumber = '51900456625';

    // Función para trackear clics en WhatsApp
    function trackWhatsAppClick(productId, productName) {
        // Puedes guardar esto en localStorage o enviar a Google Analytics
        console.log('Producto clickeado para WhatsApp:', {
            id: productId,
            name: productName,
            timestamp: new Date().toISOString()
        });
        
        // Opcional: Guardar en localStorage para analytics
        let whatsappClicks = JSON.parse(localStorage.getItem('whatsapp_clicks') || '[]');
        whatsappClicks.push({
            product_id: productId,
            product_name: productName,
            date: new Date().toISOString()
        });
        localStorage.setItem('whatsapp_clicks', JSON.stringify(whatsappClicks));
    }

    // Función para ordenar por precio
    function ordenarPrecio(order = 'asc') {
        cargarProductos({ sort_price: order });
    }

    // Función para cargar productos con filtros
    function cargarProductos(filters = {}) {
        $.ajax({
            url: '{{ route("home") }}',
            type: 'GET',
            data: filters,
            beforeSend: function() {
                $('#productos').html('<div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin fa-3x text-white"></i></div>');
            },
            success: function(response) {
                $('#productos').html(response.html);
                $('#pagination').html(response.pagination);
            },
            error: function() {
                $('#productos').html('<div class="col-12 text-center py-5"><p class="text-white">Error al cargar productos</p></div>');
            }
        });
    }

    // Paginación con AJAX
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#productos').html(response.html);
                $('#pagination').html(response.pagination);
                
                // Scroll suave hacia arriba
                $('html, body').animate({
                    scrollTop: $('#productos').offset().top - 100
                }, 500);
            }
        });
    });

   // Variables globales para el modal de imágenes
    let currentImages = [];
    let currentIndex = 0;
    let imageModal = null;

    // Inicializar el modal cuando el DOM esté listo
    $(document).ready(function() {
        const modalElement = document.getElementById('imageModal');
        if (modalElement) {
            imageModal = new bootstrap.Modal(modalElement);
        }
        
        // Configurar eventos de navegación
        $('#prevImageBtn').on('click', function(e) {
            e.stopPropagation();
            showImage(currentIndex - 1);
        });
        
        $('#nextImageBtn').on('click', function(e) {
            e.stopPropagation();
            showImage(currentIndex + 1);
        });
        
        // Eventos de teclado
        $(document).on('keydown', function(e) {
            if ($('#imageModal').hasClass('show')) {
                if (e.key === 'ArrowLeft') {
                    showImage(currentIndex - 1);
                } else if (e.key === 'ArrowRight') {
                    showImage(currentIndex + 1);
                } else if (e.key === 'Escape') {
                    imageModal.hide();
                }
            }
        });
    });

    // Función principal para abrir el modal
    window.openImageModal = function(productId, images) {
        console.log('Abriendo modal para producto:', productId);
        console.log('Imágenes recibidas:', images);
        
        try {
            // Asegurarse de que images sea un array
            if (!Array.isArray(images)) {
                images = JSON.parse(images);
            }
            
            if (!images || images.length === 0) {
                alert('Este producto no tiene imágenes disponibles.');
                return;
            }
            
            // Guardar las imágenes y resetear el índice
            currentImages = images;
            currentIndex = 0;
            
            // Mostrar la primera imagen
            showImage(0);
            
            // Crear indicadores
            createImageIndicators();
            
            // Mostrar flechas si hay más de una imagen
            updateNavigationButtons();
            
            // Mostrar el modal
            if (imageModal) {
                imageModal.show();
            } else {
                // Si no se inicializó antes, hacerlo ahora
                const modalElement = document.getElementById('imageModal');
                if (modalElement) {
                    imageModal = new bootstrap.Modal(modalElement);
                    imageModal.show();
                } else {
                    alert('Error: No se encontró el modal.');
                }
            }
            
        } catch (error) {
            console.error('Error al abrir el modal:', error);
            alert('Error al cargar las imágenes.');
        }
    }

    // Función para mostrar una imagen específica
    function showImage(index) {
        if (currentImages.length === 0) return;
        
        // Ajustar el índice (circular)
        currentIndex = (index + currentImages.length) % currentImages.length;
        const image = currentImages[currentIndex];
        
        // Actualizar la imagen en el modal
        const imgElement = document.getElementById('modalMainImage');
        if (imgElement && image && image.url) {
            // Añadir efecto de fade
            imgElement.style.opacity = '0';
            
            setTimeout(() => {
                imgElement.src = image.url;
                imgElement.alt = image.alt || 'Producto';
                imgElement.style.opacity = '1';
                
                // Actualizar indicadores
                updateImageIndicators();
                updateImageCounter();
                
                // Pre-cargar imágenes adyacentes para mejor experiencia
                preloadAdjacentImages();
            }, 200);
        }
    }

    // Crear indicadores (puntos) para las imágenes
    function createImageIndicators() {
        const indicatorsContainer = document.getElementById('imageIndicators');
        indicatorsContainer.innerHTML = '';
        
        currentImages.forEach((_, index) => {
            const indicator = document.createElement('div');
            indicator.className = 'image-indicator';
            indicator.style.cssText = `
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background-color: ${index === 0 ? '#fff' : 'rgba(255,255,255,0.5)'};
                cursor: pointer;
                transition: all 0.3s ease;
            `;
            
            indicator.addEventListener('click', () => {
                showImage(index);
            });
            
            indicator.addEventListener('mouseenter', () => {
                indicator.style.transform = 'scale(1.2)';
                indicator.style.backgroundColor = '#fff';
            });
            
            indicator.addEventListener('mouseleave', () => {
                indicator.style.transform = 'scale(1)';
                if (index !== currentIndex) {
                    indicator.style.backgroundColor = 'rgba(255,255,255,0.5)';
                }
            });
            
            indicatorsContainer.appendChild(indicator);
        });
    }

    // Actualizar los indicadores según la imagen actual
    function updateImageIndicators() {
        const indicators = document.querySelectorAll('.image-indicator');
        indicators.forEach((indicator, index) => {
            indicator.style.backgroundColor = index === currentIndex ? '#fff' : 'rgba(255,255,255,0.5)';
            indicator.style.transform = index === currentIndex ? 'scale(1.2)' : 'scale(1)';
        });
    }

    // Actualizar el contador de imágenes
    function updateImageCounter() {
        const counterElement = document.getElementById('imageCounter');
        if (counterElement) {
            counterElement.textContent = `${currentIndex + 1} / ${currentImages.length}`;
        }
    }

    // Mostrar/ocultar flechas de navegación
    function updateNavigationButtons() {
        const prevBtn = document.getElementById('prevImageBtn');
        const nextBtn = document.getElementById('nextImageBtn');
        
        if (currentImages.length > 1) {
            prevBtn.style.display = 'block';
            nextBtn.style.display = 'block';
            
            // Efectos hover en flechas
            [prevBtn, nextBtn].forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(255,255,255,0.9)';
                    this.style.transform = 'scale(1.1)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = 'rgba(0,0,0,0.7)';
                    this.style.transform = 'scale(1)';
                });
            });
        } else {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        }
    }

    // Función para pre-cargar imágenes
    function preloadAdjacentImages() {
        const nextIndex = (currentIndex + 1) % currentImages.length;
        const prevIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
        
        [nextIndex, prevIndex].forEach(index => {
            if (currentImages[index] && currentImages[index].url) {
                const img = new Image();
                img.src = currentImages[index].url;
            }
        });
    }
</script>
@endpush