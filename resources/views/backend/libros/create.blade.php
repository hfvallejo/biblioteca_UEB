{{-- @extends('layouts.app') --}}  
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">  

{{-- @section('content') --}}     
<div class="container mt-4">         
    <h1 class="mb-4">Agregar Libro</h1>     

    <!-- Mensaje de éxito -->
    <div id="mensaje-exito" class="alert alert-success d-none" role="alert"></div>
    <!-- Mensaje de error -->
    <div id="mensaje-error" class="alert alert-danger d-none" role="alert"></div>

    <form id="formCrearLibro" action="{{ route('libros.store') }}" method="POST" enctype="multipart/form-data">                         
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', isset($libro) ? $libro->titulo : '') }}">
            @error('titulo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" name="autor" id="autor" class="form-control" value="{{ old('autor', isset($libro) ? $libro->autor : '') }}">
            @error('autor')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Género</label>
            <input type="text" name="genero" id="genero" class="form-control" value="{{ old('genero', isset($libro) ? $libro->genero : '') }}">
            @error('genero')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="anio" class="form-label">Año</label>
            <input type="number" name="anio" id="anio" class="form-control" value="{{ old('anio', isset($libro) ? $libro->anio : '') }}">
            @error('anio')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select">
                <option value="disponible" {{ old('estado', isset($libro) ? $libro->estado : '') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="prestado" {{ old('estado', isset($libro) ? $libro->estado : '') == 'prestado' ? 'selected' : '' }}>Prestado</option>
            </select>
            @error('estado')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Mostrar portada guardada si existe --}}
        @if(isset($libro) && $libro->portada)
            <div class="mb-3">
                <label class="form-label">Portada Actual</label>
                <div>
                    <img src="{{ asset('storage/' . $libro->portada) }}" alt="Portada del libro" style="max-height: 150px; border-radius: 5px;">
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label for="portada" class="form-label">Portada del Libro</label>
            <input type="file" name="portada" id="portada" class="form-control" accept="image/*" onchange="mostrarPrevia(event)">
            @error('portada')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <!-- Imagen vista previa -->
            <div class="mt-2">
                <img id="previewPortada" src="#" alt="Vista previa de portada" style="max-height: 150px; display: none; border-radius: 5px;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar Libro
        </button>
    </form>     
</div>  

<script src="{{ asset('js/jquery.min.js') }}"></script> 
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> 
<script src="{{ asset('js/adminlte.min.js') }}"></script>  

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mensajeDiv = document.getElementById('mensaje-exito');
    const errorDiv = document.getElementById('mensaje-error');
    const form = document.getElementById('formCrearLibro');

    // Mostrar mensaje de éxito guardado en sessionStorage (y ocultarlo después)
    const mensaje = sessionStorage.getItem('mensajeLibro');
    if (mensaje && mensajeDiv) {
        mensajeDiv.textContent = mensaje;
        mensajeDiv.classList.remove('d-none');
        sessionStorage.removeItem('mensajeLibro');

        setTimeout(() => {
            mensajeDiv.classList.add('d-none');
        }, 4000);
    }

    // Autoguardado de campos en localStorage
    const campos = ['titulo', 'autor', 'genero', 'anio', 'estado'];
    campos.forEach(campo => {
        const input = document.querySelector(`[name="${campo}"]`);
        if (!input) return;

        // Restaurar valor si existe
        const saved = localStorage.getItem('libroCreate_' + campo);
        if (saved) input.value = saved;

        // Guardar al escribir
        input.addEventListener('input', () => {
            localStorage.setItem('libroCreate_' + campo, input.value);
        });
    });

    // Validación simple al enviar el formulario
    form.addEventListener('submit', function(e) {
        errorDiv.classList.add('d-none');
        errorDiv.textContent = '';

        const titulo = form.titulo.value.trim();
        const autor = form.autor.value.trim();

        if (!titulo || !autor) {
            e.preventDefault();
            errorDiv.textContent = 'Por favor, complete el título y el autor.';
            errorDiv.classList.remove('d-none');
            return false;
        }

        // Si pasa validación, limpiar localStorage y guardar mensaje en sessionStorage
        campos.forEach(campo => {
            localStorage.removeItem('libroCreate_' + campo);
        });
        sessionStorage.setItem('mensajeLibro', '¡Libro guardado exitosamente!');
    });
});

// Función para mostrar vista previa de la imagen seleccionada
function mostrarPrevia(event) {
    const input = event.target;
    const preview = document.getElementById('previewPortada');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>
{{-- @endsection --}}

