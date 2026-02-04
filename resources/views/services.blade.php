@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
<section class="services">
    <div class="container">
        <h1 class="page-title">Nuestros Servicios</h1>
        
        <div class="services-grid">
            <!-- Servicio 1 -->
            <div class="service-card">
                <h3>Servicio 1</h3>
                <p>Descripción detallada del servicio 1.</p>
                <ul class="service-features">
                    <li>Característica 1</li>
                    <li>Característica 2</li>
                    <li>Característica 3</li>
                </ul>
            </div>
            
            <!-- Servicio 2 -->
            <div class="service-card">
                <h3>Servicio 2</h3>
                <p>Descripción detallada del servicio 2.</p>
                <ul class="service-features">
                    <li>Característica 1</li>
                    <li>Característica 2</li>
                    <li>Característica 3</li>
                </ul>
            </div>
            
            <!-- Servicio 3 -->
            <div class="service-card">
                <h3>Servicio 3</h3>
                <p>Descripción detallada del servicio 3.</p>
                <ul class="service-features">
                    <li>Característica 1</li>
                    <li>Característica 2</li>
                    <li>Característica 3</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection