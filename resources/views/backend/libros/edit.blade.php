{{-- @extends('layouts.app') --}} 
{{-- @section('content') --}}

@php
    foreach (['titulo', 'autor', 'genero', 'anio', 'estado'] as $campo) {
        if (!old($campo)) {
            request()->merge([$campo => $libro->$campo ?? '']);
        }
    }
@endphp

{{-- Cargar Bootstrap y estilos base (heredados del panel) --}}
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

<div class="container">
    <h1>Editar Libro</h1>
    
    <form id="form-libro" action="{{ route('libros.update', $libro) }}" method="POST"enctype="multipart/form-data">>
        @csrf
        @method('PUT')

        @include('backend.libros.partials.form')

        <button type="submit" class="btn btn-primary" 
            onclick="sessionStorage.setItem('mensajeLibro', '¡Libro actualizado exitosamente!')">
            Guardar Cambios
        </button>
    </form>

    {{-- 🔎 Sección visual para verificar LocalStorage --}}
    <div class="mt-4 alert alert-info" id="storage-info" style="display: none;"></div>
</div>

{{-- scripts para Cargar Bootstrap y estilos base --}}
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/adminlte.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ✅ Mostrar mensaje de éxito si está en SessionStorage
    const mensaje = sessionStorage.getItem('mensajeLibro');
    if (mensaje) {
        alert(mensaje);
        sessionStorage.removeItem('mensajeLibro');
    }

    const campos = ['titulo', 'autor', 'genero', 'anio', 'estado'];

    // Recuperar valores guardados y llenar campos
    campos.forEach(campo => {
        const valorGuardado = localStorage.getItem('libro_' + campo);
        if (valorGuardado) {
            const input = document.querySelector(`[name="${campo}"]`);
            if (input) input.value = valorGuardado;
        }
    });

    // Guardar valores automáticamente cuando el usuario escribe
    campos.forEach(campo => {
        const input = document.querySelector(`[name="${campo}"]`);
        if (input) {
            input.addEventListener('input', () => {
                localStorage.setItem('libro_' + campo, input.value);
            });
        }
    });

    // Eliminar valores después de guardar
    document.getElementById('form-libro').addEventListener('submit', () => {
        campos.forEach(campo => {
            localStorage.removeItem('libro_' + campo);
        });
    });

    // Mostrar resumen real de localStorage en la alerta azul
    const div = document.getElementById('storage-info');
    let resumen = '<strong>📦 Datos guardados localmente:</strong><ul>';
    let hayDatos = false;

    campos.forEach(campo => {
        const val = localStorage.getItem('libro_' + campo);
        if (val) {
            resumen += `<li><strong>${campo}:</strong> ${val}</li>`;
            hayDatos = true;
        }
    });

    resumen += '</ul>';
    if (hayDatos) {
        div.innerHTML = resumen;
        div.style.display = 'block';
    }
});
</script>

{{-- @endsection --}}
