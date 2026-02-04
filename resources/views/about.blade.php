@extends('layouts.app')

@section('title', 'Nosotros')

@section('content')
<section class="about">
    <div class="container">
        <h1 class="page-title">Sobre Nosotros</h1>
        
        <div class="about-content">
            <div class="about-text">
                <h2>Nuestra Historia</h2>
                <p>Aquí va el contenido sobre tu empresa, historia, misión y visión.</p>
                
                <h2>Nuestra Misión</h2>
                <p>Descripción de la misión de tu empresa.</p>
                
                <h2>Nuestro Equipo</h2>
                <p>Información sobre tu equipo o valores.</p>
            </div>
            
            <!-- Puedes agregar una imagen si lo deseas -->
            <div class="about-image">
                <!-- <img src="{{ asset('images/about.jpg') }}" alt="Nosotros"> -->
            </div>
        </div>
    </div>
</section>
@endsection