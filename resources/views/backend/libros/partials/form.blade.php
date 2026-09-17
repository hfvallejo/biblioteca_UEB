@csrf

{{-- Título --}}
<div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
           value="{{ old('titulo', $libro->titulo ?? '') }}">
    @error('titulo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Autor --}}
<div class="mb-3">
    <label for="autor" class="form-label">Autor</label>
    <input type="text" name="autor" class="form-control @error('autor') is-invalid @enderror"
           value="{{ old('autor', $libro->autor ?? '') }}">
    @error('autor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Género --}}
<div class="mb-3">
    <label for="genero" class="form-label">Género</label>
    <input type="text" name="genero" class="form-control @error('genero') is-invalid @enderror"
           value="{{ old('genero', $libro->genero ?? '') }}">
    @error('genero')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Año --}}
<div class="mb-3">
    <label for="anio" class="form-label">Año</label>
    <input type="number" name="anio" class="form-control @error('anio') is-invalid @enderror"
           value="{{ old('anio', $libro->anio ?? '') }}">
    @error('anio')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Estado --}}
<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <select name="estado" class="form-select @error('estado') is-invalid @enderror">
        <option value="">Seleccionar...</option>
        <option value="disponible" {{ old('estado', $libro->estado ?? '') == 'disponible' ? 'selected' : '' }}>Disponible</option>
        <option value="prestado" {{ old('estado', $libro->estado ?? '') == 'prestado' ? 'selected' : '' }}>Prestado</option>
    </select>
    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Portada --}}
<div class="mb-3">
    <label for="portada" class="form-label">Portada del Libro</label>
    <input type="file" name="portada" id="portada" class="form-control" accept="image/*">
    @error('portada')
        <small class="text-danger">{{ $message }}</small>
    @enderror

    @if(isset($libro) && $libro->portada)
        <div class="mt-2">
            <small>Portada actual:</small><br>
            <img src="{{ asset('storage/' . $libro->portada) }}" alt="Portada actual" style="max-width: 150px; margin-top: 5px;">
        </div>
    @endif
</div>
