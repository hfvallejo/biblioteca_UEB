{{-- resources/views/library-api.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Biblioteca Open Library API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #loading {
            display: none;
        }

        #error-message {
            display: none;
        }

        .modal-img {
            width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h1 class="mb-4 text-center">Buscador de Libros (Open Library API)</h1>

        {{-- Mensaje de error --}}
        <div id="error-message" class="alert alert-danger" role="alert"></div>

        {{-- Loader --}}
        <div id="loading" class="text-center mb-3">
            <div class="spinner-border text-primary" role="status"></div>
            <span class="ms-2">Cargando...</span>
        </div>

        {{-- Formulario de búsqueda por título --}}
        <form id="searchForm" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar por título de libro"
                    required>
            </div>
            <div class="col-md-3">
                <select id="viewType" class="form-select">
                    <option value="cards">Ver como tarjetas</option>
                    <option value="table">Ver como tabla</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>

        <div id="resultsCount" class="mb-2"></div>
        <div id="resultsContainer" class="row"></div>

        <hr class="my-5">

        {{-- Formulario de búsqueda por autor --}}
        <h3 class="mb-3">Buscar libros por autor</h3>
        <form id="authorSearchForm" class="row g-3 mb-4">
            <div class="col-md-9">
                <input type="text" id="authorInput" class="form-control" placeholder="Nombre del autor" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-100">Buscar por autor</button>
            </div>
        </form>
        <div id="authorResultsCount" class="mb-2"></div>
        <div id="authorResultsContainer" class="row"></div>
    </div>

    {{-- Modal para detalles del libro --}}
    <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Detalles del Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="bookModalBody">
                    {{-- Aquí se cargan los detalles dinámicamente --}}
                </div>
            </div>
        </div>
    </div>

    {{--  Modal para mostrar solo la portada --}}
    <div class="modal fade" id="coverModal" tabindex="-1" aria-labelledby="coverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coverModalLabel">Portada del Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="coverImage" class="modal-img" src="" alt="Portada del libro">
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS y dependencias --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- modal para portada --}}
    <script>
        function showCoverModal(coverUrl) {
            const coverImg = document.getElementById('coverImage');
            coverImg.src = coverUrl;
            const modal = new bootstrap.Modal(document.getElementById('coverModal'));
            modal.show();
        }
    </script>

    {{--JS personalizado --}}
    <script src="{{ asset('js/library.js') }}"></script>
</body>

</html>
