{{-- @extends('layouts.app') --}}

{{-- Cargar Bootstrap y estilos base (heredados del panel) --}}
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Libros</h1>
        <a href="{{ route('libros.create') }}" class="btn btn-success" target="frameprincipal">Agregar Libro</a>
    </div>

    <div class="mb-3">
        <input type="text" id="busquedaLibro" class="form-control" placeholder="Buscar libro...">
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($libros->count())
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Portada</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Género</th>
                <th>Año</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($libros as $libro)
            <tr>
                <td>{{ $libro->id }}</td>
                <td>
                    @php
                        $rutaPortada = storage_path('app/public/' . $libro->portada);
                    @endphp

                    @if($libro->portada && file_exists($rutaPortada))
                        <img src="{{ asset('storage/' . $libro->portada) }}" alt="Portada" style="max-height: 50px; object-fit: cover; border-radius: 3px;">
                    @else
                        <span class="text-muted">Sin portada</span>
                    @endif
                </td>
                <td>{{ $libro->titulo }}</td>
                <td>{{ $libro->autor }}</td>
                <td>{{ $libro->genero }}</td>
                <td>{{ $libro->anio }}</td>
                <td>
                    <span class="badge {{ $libro->estado == 'disponible' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ ucfirst($libro->estado) }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('libros.show', $libro) }}" class="btn btn-sm btn-info d-flex align-items-center gap-1">
                            @if($libro->portada && file_exists($rutaPortada))
                                <img src="{{ asset('storage/' . $libro->portada) }}" alt="Portada" width="20" height="25" style="object-fit: cover; border-radius: 3px;">
                            @endif
                            Ver
                        </a>

                        <form action="{{ route('libros.edit', $libro) }}" method="GET" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-primary">Editar</button>
                        </form>

                        <form action="{{ route('libros.destroy', $libro) }}" method="POST" class="d-inline"
                              onsubmit="sessionStorage.setItem('mensajeLibro','¡Libro eliminado exitosamente!'); return confirm('¿Estás seguro de eliminar este libro?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="alert alert-warning">
            No hay libros registrados aún.
        </div>
    @endif
</div>

{{-- scripts para Cargar Bootstrap y estilos base --}}
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script>
    const inputBusqueda = document.getElementById('busquedaLibro');
    const tabla = document.querySelector('table tbody');

    document.addEventListener('DOMContentLoaded', () => {
        // LocalStorage: recuperar búsqueda
        const valorGuardado = localStorage.getItem('busquedaLibro');
        if (valorGuardado) {
            inputBusqueda.value = valorGuardado;
        }

        // SessionStorage: mostrar mensaje (crear/editar/eliminar)
        const mensaje = sessionStorage.getItem('mensajeLibro');
        if (mensaje) {
            alert(mensaje);
            sessionStorage.removeItem('mensajeLibro');
        }

        // Aplicar filtro inicial en caso que haya valor guardado
        filtrarTabla(valorGuardado);
    });

    // LocalStorage: guardar búsqueda al escribir y filtrar tabla
    inputBusqueda.addEventListener('input', () => {
        localStorage.setItem('busquedaLibro', inputBusqueda.value);
        filtrarTabla(inputBusqueda.value);
    });

    // Función para filtrar filas de la tabla según texto
    function filtrarTabla(textoFiltro) {
        const filtro = textoFiltro ? textoFiltro.toLowerCase() : '';
        const filas = tabla.querySelectorAll('tr');

        filas.forEach(fila => {
            const textoFila = [...fila.cells]
                .slice(0, fila.cells.length - 1)
                .map(td => td.textContent.toLowerCase())
                .join(' ');

            if (textoFila.includes(filtro)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }
</script>

{{-- @endsection --}}
