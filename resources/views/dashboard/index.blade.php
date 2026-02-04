@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="h2">Panel de Control</h1>
    <p class="lead">Bienvenido al sistema de administración</p>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card stat-card-primary text-white h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <div class="text-xs fw-bold">Usuarios Totales</div>
                        <div class="h5 mb-0 fw-bold" id="totalUsers">152</div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> 12%
                            </span>
                            <span class="text-white-50"> desde el mes pasado</span>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-users card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card stat-card-success text-white h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <div class="text-xs fw-bold">Ventas Totales</div>
                        <div class="h5 mb-0 fw-bold" id="totalSales">$45,200</div>
                        <div class="mt-2">
                            <span class="text-warning">
                                <i class="fas fa-arrow-up"></i> 8%
                            </span>
                            <span class="text-white-50"> desde el mes pasado</span>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-dollar-sign card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card stat-card-warning text-white h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <div class="text-xs fw-bold">Pedidos Activos</div>
                        <div class="h5 mb-0 fw-bold" id="totalOrders">24</div>
                        <div class="mt-2">
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> 3%
                            </span>
                            <span class="text-white-50"> desde la semana pasada</span>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-shopping-cart card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card stat-card-danger text-white h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <div class="text-xs fw-bold">Tasa de Conversión</div>
                        <div class="h5 mb-0 fw-bold">4.8%</div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> 1.2%
                            </span>
                            <span class="text-white-50"> desde ayer</span>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-chart-line card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="row">
    <div class="col-xl-8 mb-4">
        <div class="card dashboard-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Ventas Mensuales</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 mb-4">
        <div class="card dashboard-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Distribución de Usuarios</h5>
            </div>
            <div class="card-body">
                <canvas id="usersChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Actividad Reciente</h5>
                <button class="btn btn-sm btn-primary">Ver Todo</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover" id="recentActivity">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Actividad</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Juan+Perez&background=3498db&color=fff" 
                                             class="rounded-circle me-2" width="30" height="30" alt="Juan Perez">
                                        <span>Juan Pérez</span>
                                    </div>
                                </td>
                                <td>Nuevo pedido #ORD-001</td>
                                <td>Hace 5 minutos</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Maria+Garcia&background=e74c3c&color=fff" 
                                             class="rounded-circle me-2" width="30" height="30" alt="Maria Garcia">
                                        <span>María García</span>
                                    </div>
                                </td>
                                <td>Actualización de perfil</td>
                                <td>Hace 15 minutos</td>
                                <td><span class="badge bg-info">En proceso</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Carlos+Lopez&background=2ecc71&color=fff" 
                                             class="rounded-circle me-2" width="30" height="30" alt="Carlos Lopez">
                                        <span>Carlos López</span>
                                    </div>
                                </td>
                                <td>Registro de nuevo producto</td>
                                <td>Hace 30 minutos</td>
                                <td><span class="badge bg-warning">Pendiente</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Ana+Martinez&background=9b59b6&color=fff" 
                                             class="rounded-circle me-2" width="30" height="30" alt="Ana Martinez">
                                        <span>Ana Martínez</span>
                                    </div>
                                </td>
                                <td>Pago recibido</td>
                                <td>Hace 1 hora</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Gráfico de ventas
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ventas 2023',
                    data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 30000, 40000, 38000, 45000],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        
        // Gráfico de usuarios
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        const usersChart = new Chart(usersCtx, {
            type: 'doughnut',
            data: {
                labels: ['Activos', 'Inactivos', 'Nuevos'],
                datasets: [{
                    data: [65, 20, 15],
                    backgroundColor: [
                        '#2ecc71',
                        '#e74c3c',
                        '#3498db'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
        
        // Inicializar tabla de actividad reciente
        $('#recentActivity').DataTable({
            pageLength: 5,
            lengthChange: false,
            searching: false,
            info: false,
            order: [[2, 'desc']]
        });
    });
</script>
@endpush
@endsection