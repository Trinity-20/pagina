<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Estilos personalizados -->
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 0px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--secondary-color), #1a252f);
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1050;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        /* Estado colapsado del sidebar */
        #sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }
        
        /* Overlay para móviles */
        #sidebarOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        
        #sidebarOverlay.show {
            display: block;
        }
        
        .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.2);
            text-align: center;
            position: relative;
        }
        
        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-size: 1.5rem;
            transition: opacity 0.3s;
        }
        
        #sidebar.collapsed .sidebar-header h3 {
            opacity: 0;
        }
        
        .sidebar-header h3 i {
            color: var(--primary-color);
        }
        
        /* Botón para cerrar sidebar en móviles */
        .sidebar-close-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            display: none;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            overflow-y: auto;
            max-height: calc(100vh - 180px);
        }
        
        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            position: relative;
        }
        
        .sidebar-menu a {
            color: #bdc3c7;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
            white-space: nowrap;
        }
        
        .sidebar-menu a:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            padding-left: 25px;
        }
        
        .sidebar-menu a.active {
            color: white;
            background: var(--primary-color);
        }
        
        .sidebar-menu a i {
            width: 25px;
            font-size: 1.1rem;
            transition: margin-right 0.3s;
        }
        
        #sidebar.collapsed .sidebar-menu a i {
            margin-right: 0;
        }
        
        .sidebar-menu .badge {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: opacity 0.3s;
        }
        
        #sidebar.collapsed .sidebar-menu .badge {
            opacity: 0;
        }
        
        /* Content Wrapper */
        #content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        #content.expanded {
            margin-left: 0;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 25px;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        
        #sidebarCollapse {
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 1.2rem;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        #sidebarCollapse:hover {
            background-color: #f8f9fa;
        }
        
        /* Estilos para móviles */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                box-shadow: none;
            }
            
            #sidebar.mobile-open {
                margin-left: 0;
            }
            
            #content {
                margin-left: 0;
                width: 100%;
            }
            
            #sidebarCollapse {
                display: block;
            }
            
            .sidebar-close-btn {
                display: block;
            }
            
            /* Ajustes para contenido en móviles */
            .main-content {
                padding: 20px 15px;
            }
            
            .page-header h1 {
                font-size: 1.5rem;
            }
            
            .page-header p {
                font-size: 0.9rem;
            }
            
            /* Ajustes para tarjetas en móviles */
            .dashboard-card {
                margin-bottom: 15px;
            }
            
            .stat-card-primary,
            .stat-card-success,
            .stat-card-warning,
            .stat-card-danger {
                margin-bottom: 15px;
            }
            
            /* Ajustes para tablas en móviles */
            .table-responsive {
                margin: 0 -15px;
                padding: 0 15px;
            }
            
            .table-container {
                border-radius: 0;
                box-shadow: none;
            }
        }
        
        /* Estilos para tablets */
        @media (min-width: 769px) and (max-width: 992px) {
            #sidebar {
                width: 220px;
                --sidebar-width: 220px;
            }
            
            #content {
                margin-left: 220px;
            }
            
            .main-content {
                padding: 25px;
            }
            
            .sidebar-menu a {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .sidebar-menu a i {
                width: 20px;
                font-size: 1rem;
            }
        }
        
        /* Para pantallas muy pequeñas (móviles pequeños) */
        @media (max-width: 576px) {
            .top-navbar {
                padding: 10px 15px;
            }
            
            .main-content {
                padding: 15px 10px;
            }
            
            .user-dropdown span {
                display: none;
            }
            
            .page-header h1 {
                font-size: 1.3rem;
            }
            
            /* Ajustar gráficos para móviles */
            canvas {
                max-height: 200px;
            }
            
            /* Ajustar botones en móviles */
            .btn {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
            
            /* Ajustar tamaño de texto en tarjetas */
            .card-body .h5 {
                font-size: 1.25rem;
            }
            
            .card-body .text-xs {
                font-size: 0.75rem;
            }
        }
        
        /* Ajustes para cuando el sidebar está colapsado en desktop */
        @media (min-width: 769px) {
            #sidebar.collapsed {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            #sidebar.collapsed ~ #content {
                margin-left: 0;
            }
            
            #sidebar:not(.collapsed) ~ #content {
                margin-left: var(--sidebar-width);
            }
            
            /* Mostrar tooltips en sidebar colapsado */
            #sidebar.collapsed .sidebar-menu a {
                position: relative;
            }
            
            #sidebar.collapsed .sidebar-menu a::after {
                content: attr(title);
                position: absolute;
                left: 100%;
                top: 50%;
                transform: translateY(-50%);
                background: var(--secondary-color);
                color: white;
                padding: 8px 12px;
                border-radius: 4px;
                white-space: nowrap;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s;
                z-index: 1060;
                font-size: 0.9rem;
                box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
            }
            
            #sidebar.collapsed .sidebar-menu a:hover::after {
                opacity: 1;
                visibility: visible;
                left: calc(100% + 10px);
            }
        }
        
        /* Scrollbar personalizado para sidebar */
        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
        
        /* Resto de estilos permanecen igual... */
        .user-dropdown img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        .stat-card-primary {
            background: linear-gradient(45deg, var(--primary-color), #2980b9);
            color: white;
        }
        
        .stat-card-success {
            background: linear-gradient(45deg, var(--success-color), #27ae60);
            color: white;
        }
        
        .stat-card-warning {
            background: linear-gradient(45deg, var(--warning-color), #d35400);
            color: white;
        }
        
        .stat-card-danger {
            background: linear-gradient(45deg, var(--danger-color), #c0392b);
            color: white;
        }
        
        .main-content {
            padding: 30px;
        }
        
        .page-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 20px;
            margin-top: auto;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Overlay para móviles -->
    <div id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
            <button class="sidebar-close-btn" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       title="Inicio">
                        <i class="fas fa-home"></i> <span class="menu-text">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Estadísticas">
                        <i class="fas fa-chart-bar"></i> <span class="menu-text">Estadísticas</span>
                        <span class="badge bg-warning float-end">3</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Usuarios">
                        <i class="fas fa-users"></i> <span class="menu-text">Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('categories.index')}}" title="Categorias">
                        <i class="fas fa-box"></i> <span class="menu-text">Categorias</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('products.index')}}" title="Productos">
                        <i class="fas fa-box"></i> <span class="menu-text">Productos</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="#" title="Pedidos">
                        <i class="fas fa-shopping-cart"></i> <span class="menu-text">Pedidos</span>
                        <span class="badge bg-danger float-end">5</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Configuración">
                        <i class="fas fa-cog"></i> <span class="menu-text">Configuración</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('home') }}" target="_blank" title="Ver Sitio Web">
                        <i class="fas fa-external-link-alt"></i> <span class="menu-text">Ver Sitio Web</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="sidebar-footer" style="padding: 20px; position: absolute; bottom: 0; width: 100%;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> <span class="logout-text">Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </nav>
    
    <!-- Content -->
    <div id="content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="ms-3 d-none d-md-inline">Bienvenido, {{ Auth::user()->name }}</span>
                </div>
                
                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center" 
                            type="button" 
                            id="userDropdown" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                        <div class="user-dropdown me-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3498db&color=fff" 
                                 alt="{{ Auth::user()->name }}">
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Configuración</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">© {{ date('Y') }} Sistema. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p class="mb-0">v1.0.0</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Scripts personalizados para responsive -->
    <script>
        $(document).ready(function() {
            // Estado inicial del sidebar
            let sidebarState = localStorage.getItem('sidebarState');
            const isMobile = window.innerWidth <= 768;
            
            // Inicializar según el tamaño de pantalla
            if (isMobile) {
                $('#sidebar').addClass('collapsed');
                $('#content').addClass('expanded');
            } else {
                if (sidebarState === 'collapsed') {
                    $('#sidebar').addClass('collapsed');
                    $('#content').addClass('expanded');
                }
            }
            
            // Función para alternar sidebar
            function toggleSidebar() {
                const isMobileView = window.innerWidth <= 768;
                const sidebar = $('#sidebar');
                const content = $('#content');
                const overlay = $('#sidebarOverlay');
                
                if (isMobileView) {
                    // En móviles, toggle con overlay
                    sidebar.toggleClass('mobile-open');
                    overlay.toggleClass('show');
                    $('body').toggleClass('no-scroll');
                } else {
                    // En desktop, toggle normal
                    sidebar.toggleClass('collapsed');
                    content.toggleClass('expanded');
                    
                    // Guardar estado en localStorage
                    const isCollapsed = sidebar.hasClass('collapsed');
                    localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'expanded');
                }
            }
            
            // Toggle Sidebar con botón hamburguesa
            $('#sidebarCollapse').on('click', toggleSidebar);
            
            // Cerrar sidebar con botón X (solo móviles)
            $('#sidebarClose').on('click', function() {
                $('#sidebar').removeClass('mobile-open');
                $('#sidebarOverlay').removeClass('show');
                $('body').removeClass('no-scroll');
            });
            
            // Cerrar sidebar al hacer clic en overlay
            $('#sidebarOverlay').on('click', function() {
                $('#sidebar').removeClass('mobile-open');
                $(this).removeClass('show');
                $('body').removeClass('no-scroll');
            });
            
            // Cerrar sidebar al hacer clic en un enlace (solo móviles)
            $('#sidebar .sidebar-menu a').on('click', function() {
                if (window.innerWidth <= 768) {
                    $('#sidebar').removeClass('mobile-open');
                    $('#sidebarOverlay').removeClass('show');
                    $('body').removeClass('no-scroll');
                }
            });
            
            // Detectar cambios de tamaño de ventana
            let resizeTimer;
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    const isMobileNow = window.innerWidth <= 768;
                    const sidebar = $('#sidebar');
                    const content = $('#content');
                    
                    if (isMobileNow) {
                        // Cambiar a vista móvil
                        sidebar.removeClass('collapsed').addClass('collapsed');
                        content.addClass('expanded');
                        $('#sidebarOverlay').removeClass('show');
                        sidebar.removeClass('mobile-open');
                        $('body').removeClass('no-scroll');
                    } else {
                        // Cambiar a vista desktop
                        sidebar.removeClass('mobile-open');
                        $('#sidebarOverlay').removeClass('show');
                        $('body').removeClass('no-scroll');
                        
                        // Restaurar estado guardado
                        const savedState = localStorage.getItem('sidebarState');
                        if (savedState === 'collapsed') {
                            sidebar.addClass('collapsed');
                            content.addClass('expanded');
                        } else {
                            sidebar.removeClass('collapsed');
                            content.removeClass('expanded');
                        }
                    }
                }, 250);
            });
            
            // Tooltips para sidebar colapsado en desktop
            function initSidebarTooltips() {
                if (window.innerWidth > 768) {
                    $('#sidebar.collapsed .sidebar-menu a').each(function() {
                        const title = $(this).find('.menu-text').text();
                        $(this).attr('title', title);
                    });
                } else {
                    $('#sidebar .sidebar-menu a').removeAttr('title');
                }
            }
            
            initSidebarTooltips();
            $(window).on('resize', initSidebarTooltips);
            
            // Inicializar DataTables
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable({
                    responsive: true
                });
            }
            
            // Añadir clase para evitar scroll cuando sidebar está abierto en móviles
            $(document).on('show.bs.dropdown', function() {
                if ($('#sidebar').hasClass('mobile-open')) {
                    $('body').addClass('no-scroll');
                }
            });
            
            $(document).on('hide.bs.dropdown', function() {
                $('body').removeClass('no-scroll');
            });
            
            // Notificaciones
            $('.alert').delay(5000).fadeOut(400);
            
            // Tooltips de Bootstrap
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Confirmación para acciones importantes
            $('.confirm-action').on('click', function(e) {
                if (!confirm($(this).data('confirm') || '¿Estás seguro?')) {
                    e.preventDefault();
                }
            });
            
            // Estilo CSS adicional para body cuando sidebar está abierto en móviles
            $('<style>').text(
                'body.no-scroll { overflow: hidden; } ' +
                '@media (max-width: 768px) { ' +
                '  #sidebar.mobile-open { box-shadow: 3px 0 15px rgba(0,0,0,0.2); } ' +
                '}'
            ).appendTo('head');
        });
    </script>
    
    @stack('scripts')
</body>
</html>