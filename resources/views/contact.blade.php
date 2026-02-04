@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<section class="contact">
    <div class="container">
        <h1 class="page-title">Contáctanos</h1>
        
        <div class="contact-content">
            <!-- Información de contacto -->
            <div class="contact-info">
                <h2>Información de Contacto</h2>
                <ul class="contact-details">
                    <li><strong>Email:</strong> info@misitio.com</li>
                    <li><strong>Teléfono:</strong> +1 234 567 890</li>
                    <li><strong>Dirección:</strong> Ciudad, País</li>
                    <li><strong>Horario:</strong> Lunes a Viernes, 9:00 - 18:00</li>
                </ul>
            </div>
            
            <!-- Formulario de contacto -->
            <div class="contact-form">
                <h2>Envíanos un Mensaje</h2>
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Asunto</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection