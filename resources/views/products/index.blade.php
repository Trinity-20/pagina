@extends('layouts.crud')

@section('title', 'Productos')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 mb-0">Productos</h1>
            <p class="text-muted">Administra el inventario de productos</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Buscar producto..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="featured" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Destacados</option>
                            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>No destacados</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-filter me-2"></i> Filtrar
                        </button>
                        @if(request()->hasAny(['search', 'category', 'status', 'featured']))
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Resultados de búsqueda -->
                @if(request()->hasAny(['search', 'category', 'status', 'featured']))
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Filtros aplicados:
                            @if(request('search'))
                                <span class="badge bg-light text-dark mx-1">Buscar: "{{ request('search') }}"</span>
                            @endif
                            @if(request('category'))
                                @php $cat = $categories->firstWhere('id', request('category')); @endphp
                                @if($cat)
                                    <span class="badge bg-light text-dark mx-1">Categoría: {{ $cat->name }}</span>
                                @endif
                            @endif
                            @if(request('status') == 'active')
                                <span class="badge bg-light text-dark mx-1">Estado: Activos</span>
                            @elseif(request('status') == 'inactive')
                                <span class="badge bg-light text-dark mx-1">Estado: Inactivos</span>
                            @endif
                            @if(request('featured') === '1')
                                <span class="badge bg-light text-dark mx-1">Destacados</span>
                            @elseif(request('featured') === '0')
                                <span class="badge bg-light text-dark mx-1">No destacados</span>
                            @endif
                            
                            @if($products->total() > 0)
                                <span class="ms-2">{{ $products->total() }} producto(s) encontrado(s)</span>
                            @endif
                        </small>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="card">
        <div class="card-body">
            @if($products->total() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Creado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $mainImage = $product->images->firstWhere('is_main') ?? $product->images->first();
                                            @endphp
                                            @if($mainImage)
                                                <img src="{{ Storage::url($mainImage->path) }}" 
                                                     alt="{{ $product->name }}"
                                                     class="rounded me-3"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                @if(request('search'))
                                                    @php
                                                        $searchTerm = request('search');
                                                        $highlightedName = preg_replace("/$searchTerm/i", "<mark>$0</mark>", $product->name);
                                                    @endphp
                                                    <strong>{!! $highlightedName !!}</strong>
                                                @else
                                                    <strong>{{ $product->name }}</strong>
                                                @endif
                                                <br>
                                                <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge bg-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">Sin categoría</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>${{ number_format($product->price, 2) }}</strong><br>
                                        @if($product->compare_price)
                                            <small class="text-danger text-decoration-line-through">
                                                ${{ number_format($product->compare_price, 2) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->stock > 10)
                                            <span class="badge bg-success">{{ $product->stock }} unidades</span>
                                        @elseif($product->stock > 0)
                                            <span class="badge bg-warning">{{ $product->stock }} unidades</span>
                                        @else
                                            <span class="badge bg-danger">Agotado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="badge bg-warning mt-1 d-block">Destacado</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('products.show', $product) }}" 
                                            class="btn btn-sm btn-outline-info" 
                                            title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <a href="{{ route('products.edit', $product) }}" 
                                            class="btn btn-sm btn-outline-primary" 
                                            title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning toggle-status-btn"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    data-is-active="{{ $product->is_active }}"
                                                    title="{{ $product->is_active ? 'Desactivar' : 'Activar' }}">
                                                @if($product->is_active)
                                                    <i class="fas fa-eye-slash"></i>
                                                @else
                                                    <i class="fas fa-eye"></i>
                                                @endif
                                            </button>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-secondary toggle-featured-btn"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    data-is-featured="{{ $product->is_featured }}"
                                                    title="{{ $product->is_featured ? 'Quitar destacado' : 'Destacar' }}">
                                                @if($product->is_featured)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            </button>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger delete-btn"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <!-- Mensaje cuando no hay resultados -->
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-box-open fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">
                        @if(request()->hasAny(['search', 'category', 'status', 'featured']))
                            No se encontraron productos con los filtros aplicados
                        @else
                            No hay productos registrados
                        @endif
                    </h5>
                    @if(request()->hasAny(['search', 'category', 'status', 'featured']))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i> Ver todos los productos
                        </a>
                    @else
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Crear primer producto
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Formularios dinámicos (ocultos) -->
<form id="toggleStatusForm" method="POST" action="" style="display: none;">
    @csrf
    @method('PUT')
</form>

<form id="toggleFeaturedForm" method="POST" action="" style="display: none;">
    @csrf
    @method('PUT')
</form>

<form id="deleteForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        // Configurar CSRF token para todas las peticiones AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Cambiar estado activo/inactivo
        $('.toggle-status-btn').on('click', function() {
            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const isActive = $(this).data('is-active');
            const action = "{{ route('products.toggle-status', ':id') }}".replace(':id', productId);
            
            Swal.fire({
                title: '¿Cambiar estado?',
                html: `¿Estás seguro de <strong>${isActive ? 'desactivar' : 'activar'}</strong> el producto <strong>"${productName}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#toggleStatusForm').attr('action', action);
                    $('#toggleStatusForm').submit();
                }
            });
        });

        // Cambiar estado destacado
        $('.toggle-featured-btn').on('click', function() {
            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const isFeatured = $(this).data('is-featured');
            const action = "{{ route('products.toggle-featured', ':id') }}".replace(':id', productId);
            
            Swal.fire({
                title: '¿Cambiar destacado?',
                html: `¿Estás seguro de <strong>${isFeatured ? 'quitar de destacados' : 'destacar'}</strong> el producto <strong>"${productName}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#toggleFeaturedForm').attr('action', action);
                    $('#toggleFeaturedForm').submit();
                }
            });
        });

        // Eliminar producto
        $('.delete-btn').on('click', function() {
            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const action = "{{ route('products.destroy', ':id') }}".replace(':id', productId);
            
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¿Deseas eliminar el producto <strong>"${productName}"</strong>?<br><br>Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').attr('action', action);
                    $('#deleteForm').submit();
                }
            });
        });
    });
</script>
@endpush
@endsection