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
