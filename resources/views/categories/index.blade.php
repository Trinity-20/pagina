@extends('layouts.crud')

@section('title', 'Categorías')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 mb-0">Categorías</h1>
            <p class="text-muted">Administra las categorías de productos</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Nueva Categoría
            </a>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('categories.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Buscar categoría por nombre..." 
                               value="{{ request('search') }}"
                               aria-label="Buscar categoría">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i> Buscar
                    </button>
                </div>
                <div class="col-md-2">
                    @if(request('search'))
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times me-2"></i> Limpiar
                        </a>
                    @endif
                </div>
            </form>
            
            <!-- Resultados de búsqueda -->
            @if(request('search'))
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Mostrando resultados para: <strong>"{{ request('search') }}"</strong>
                        @if($categories->total() > 0)
                            - {{ $categories->total() }} categoría(s) encontrada(s)
                        @endif
                    </small>
                </div>
            @endif
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

    <!-- Tabla de categorías -->
    <div class="card">
        <div class="card-body">
            @if($categories->total() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Productos</th>
                                <th>Estado</th>
                                <th>Creado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        @if(request('search'))
                                            @php
                                                $search = request('search');
                                                $name = $category->name;
                                                $highlighted = preg_replace("/$search/i", "<mark>$0</mark>", $name);
                                            @endphp
                                            {!! $highlighted !!}
                                        @else
                                            {{ $category->name }}
                                        @endif
                                    </td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-success">Activa</span>
                                        @else
                                            <span class="badge bg-danger">Inactiva</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('categories.edit', $category) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning toggle-status-btn" 
                                                    title="Cambiar estado"
                                                    data-category-id="{{ $category->id }}"
                                                    data-category-name="{{ $category->name }}"
                                                    data-is-active="{{ $category->is_active }}">
                                                @if($category->is_active)
                                                    <i class="fas fa-eye-slash"></i>
                                                @else
                                                    <i class="fas fa-eye"></i>
                                                @endif
                                            </button>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger delete-btn" 
                                                    title="Eliminar"
                                                    data-category-id="{{ $category->id }}"
                                                    data-category-name="{{ $category->name }}"
                                                    data-products-count="{{ $category->products_count }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Mensaje cuando no hay resultados -->
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-search fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">
                        @if(request('search'))
                            No se encontraron categorías para "{{ request('search') }}"
                        @else
                            No hay categorías registradas
                        @endif
                    </h5>
                    @if(request('search'))
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i> Ver todas las categorías
                        </a>
                    @else
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Crear primera categoría
                        </a>
                    @endif
                </div>
            @endif
            
            <!-- Paginación -->
            @if($categories->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $categories->withQueryString()->links() }}
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

        // Cambiar estado
        $('.toggle-status-btn').on('click', function() {
            const categoryId = $(this).data('category-id');
            const categoryName = $(this).data('category-name');
            const isActive = $(this).data('is-active');
            const action = "{{ route('categories.toggle-status', ':id') }}".replace(':id', categoryId);
            
            Swal.fire({
                title: '¿Cambiar estado?',
                html: `¿Estás seguro de <strong>${isActive ? 'desactivar' : 'activar'}</strong> la categoría <strong>"${categoryName}"</strong>?`,
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

        // Eliminar categoría
        $('.delete-btn').on('click', function() {
            const categoryId = $(this).data('category-id');
            const categoryName = $(this).data('category-name');
            const productsCount = $(this).data('products-count');
            const action = "{{ route('categories.destroy', ':id') }}".replace(':id', categoryId);
            
            // Verificar si tiene productos
            if (productsCount > 0) {
                Swal.fire({
                    title: 'No se puede eliminar',
                    html: `La categoría <strong>"${categoryName}"</strong> tiene <strong>${productsCount} productos</strong> asociados.<br><br>Por favor, elimine o reasigne los productos primero.`,
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¿Deseas eliminar la categoría <strong>"${categoryName}"</strong>?<br><br>Esta acción no se puede deshacer.`,
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

        // Foco automático en el campo de búsqueda si hay búsqueda activa
        @if(request('search'))
            $('input[name="search"]').focus().select();
        @endif
    });
</script>
@endpush
@endsection