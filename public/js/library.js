// public/js/library.js

class LibraryAPI {
    constructor() {
        this.baseURL = "https://openlibrary.org";
        this.searchURL = "https://openlibrary.org/search.json";
        this.initializeAxios();
    }

    // Configuración inicial de Axios
    initializeAxios() {
        // Configurar interceptores para manejo de errores
        axios.interceptors.response.use(
            (response) => response,
            (error) => {
                console.error("Error en la petición:", error);
                this.showError("Error al conectar con la API");
                return Promise.reject(error);
            }
        );
    }

    // Buscar libros por título
    async searchBooks(query, limit = 10) {
        try {
            this.showLoading(true);

            const response = await axios.get(this.searchURL, {
                params: {
                    title: query,
                    limit: limit,
                    fields: "key,title,author_name,first_publish_year,isbn,cover_i,subject,publisher",
                },
            });

            this.showLoading(false);
            return response.data;
        } catch (error) {
            this.showLoading(false);
            throw error;
        }
    }

    // Buscar libros por autor
    async searchByAuthor(author, limit = 10) {
        try {
            this.showLoading(true);

            const response = await axios.get(this.searchURL, {
                params: {
                    author: author,
                    limit: limit,
                    fields: "key,title,author_name,first_publish_year,isbn,cover_i,subject,publisher",
                },
            });

            this.showLoading(false);
            return response.data;
        } catch (error) {
            this.showLoading(false);
            throw error;
        }
    }

    // Obtener detalles de un libro específico
    async getBookDetails(bookKey) {
        try {
            this.showLoading(true);

            const response = await axios.get(`${this.baseURL}${bookKey}.json`);

            this.showLoading(false);
            return response.data;
        } catch (error) {
            this.showLoading(false);
            throw error;
        }
    }

    // Obtener información de un autor
    async getAuthorInfo(authorKey) {
        try {
            this.showLoading(true);

            const response = await axios.get(
                `${this.baseURL}${authorKey}.json`
            );

            this.showLoading(false);
            return response.data;
        } catch (error) {
            this.showLoading(false);
            throw error;
        }
    }

    // Generar URL de portada del libro
    getCoverURL(coverId, size = "M") {
        if (!coverId) return "/images/no-cover.jpg"; // Imagen por defecto
        return `https://covers.openlibrary.org/b/id/${coverId}-${size}.jpg`;
    }

    // Mostrar/ocultar loading
    showLoading(show) {
        const loader = document.getElementById("loading");
        if (loader) {
            loader.style.display = show ? "block" : "none";
        }
    }

    // Mostrar errores
    showError(message) {
        const errorDiv = document.getElementById("error-message");
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = "block";
            setTimeout(() => {
                errorDiv.style.display = "none";
            }, 5000);
        }
    }

    // Renderizar resultados en cards
    renderBooksAsCards(books, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        container.innerHTML = "";

        if (!books || books.length === 0) {
            container.innerHTML =
                '<p class="text-center">No se encontraron libros.</p>';
            return;
        }

        books.forEach((book) => {
            const card = this.createBookCard(book);
            container.appendChild(card);
        });
    }

    // Crear card individual de libro
    createBookCard(book) {
        const card = document.createElement("div");
        card.className = "col-md-4 mb-4";

        const coverURL = this.getCoverURL(book.cover_i);
        const authors = book.author_name
            ? book.author_name.join(", ")
            : "Autor desconocido";
        const year = book.first_publish_year || "Año desconocido";
        const subjects = book.subject
            ? book.subject.slice(0, 3).join(", ")
            : "Sin categorías";

        card.innerHTML = `
            <div class="card h-100">
                <img src="${coverURL}" class="card-img-top" alt="${book.title}" style="height: 300px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${book.title}</h5>
                    <p class="card-text"><strong>Autor(es):</strong> ${authors}</p>
                    <p class="card-text"><strong>Año:</strong> ${year}</p>
                    <p class="card-text"><strong>Categorías:</strong> ${subjects}</p>
                    <div class="mt-auto">
                        <button class="btn btn-primary btn-sm" onclick="libraryApp.showBookDetails('${book.key}')">
                            Ver Detalles
                        </button>
                    </div>
                </div>
            </div>
        `;

        return card;
    }

    // Renderizar resultados en tabla
    renderBooksAsTable(books, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        if (!books || books.length === 0) {
            container.innerHTML =
                '<p class="text-center">No se encontraron libros.</p>';
            return;
        }

        let tableHTML = `
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Portada</th>
                        <th>Título</th>
                        <th>Autor(es)</th>
                        <th>Año</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
        `;

        books.forEach((book) => {
            const coverURL = this.getCoverURL(book.cover_i, "S");
            const authors = book.author_name
                ? book.author_name.join(", ")
                : "Autor desconocido";
            const year = book.first_publish_year || "N/A";

            tableHTML += `
                <tr>
                    <td><img src="${coverURL}" alt="${book.title}" style="width: 50px; height: 70px; object-fit: cover;"></td>
                    <td>${book.title}</td>
                    <td>${authors}</td>
                    <td>${year}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="libraryApp.showBookDetails('${book.key}')">
                            Detalles
                        </button>
                    </td>
                </tr>
            `;
        });

        tableHTML += "</tbody></table>";
        container.innerHTML = tableHTML;
    }

    // Mostrar detalles de un libro en modal
    async showBookDetails(bookKey) {
        try {
            const bookDetails = await this.getBookDetails(bookKey);
            this.displayBookModal(bookDetails);
        } catch (error) {
            this.showError("Error al cargar los detalles del libro");
        }
    }

    // Mostrar modal con detalles del libro
    displayBookModal(book) {
        const modalBody = document.getElementById("bookModalBody");
        if (!modalBody) return;

        const coverURL = book.covers
            ? this.getCoverURL(book.covers[0])
            : "/images/no-cover.jpg";

        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <img src="${coverURL}" class="img-fluid" alt="${
            book.title
        }">
                </div>
                <div class="col-md-8">
                    <h4>${book.title}</h4>
                    <p><strong>Descripción:</strong> ${
                        book.description
                            ? typeof book.description === "string"
                                ? book.description
                                : book.description.value
                            : "No disponible"
                    }</p>
                    <p><strong>Número de páginas:</strong> ${
                        book.number_of_pages || "No disponible"
                    }</p>
                    <p><strong>Fecha de publicación:</strong> ${
                        book.publish_date || "No disponible"
                    }</p>
                    <p><strong>Editorial:</strong> ${
                        book.publishers
                            ? book.publishers.join(", ")
                            : "No disponible"
                    }</p>
                </div>
            </div>
        `;

        // Mostrar el modal (asumiendo que usas Bootstrap)
        const modal = new bootstrap.Modal(document.getElementById("bookModal"));
        modal.show();
    }
}

// Inicializar la aplicación
const libraryApp = new LibraryAPI();

// Event listeners para el DOM
document.addEventListener("DOMContentLoaded", function () {
    // Búsqueda por título
    const searchForm = document.getElementById("searchForm");
    if (searchForm) {
        searchForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            const query = document.getElementById("searchInput").value.trim();
            const viewType = document.getElementById("viewType").value;

            if (query) {
                try {
                    const results = await libraryApp.searchBooks(query, 20);

                    if (viewType === "cards") {
                        libraryApp.renderBooksAsCards(
                            results.docs,
                            "resultsContainer"
                        );
                    } else {
                        libraryApp.renderBooksAsTable(
                            results.docs,
                            "resultsContainer"
                        );
                    }

                    // Mostrar estadísticas
                    document.getElementById(
                        "resultsCount"
                    ).textContent = `Se encontraron ${results.numFound} libros (mostrando ${results.docs.length})`;
                } catch (error) {
                    libraryApp.showError("Error al buscar libros");
                }
            }
        });
    }

    // Búsqueda por autor
    const authorSearchForm = document.getElementById("authorSearchForm");
    if (authorSearchForm) {
        authorSearchForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            const author = document.getElementById("authorInput").value.trim();

            if (author) {
                try {
                    const results = await libraryApp.searchByAuthor(author, 20);
                    libraryApp.renderBooksAsCards(
                        results.docs,
                        "authorResultsContainer"
                    );

                    document.getElementById(
                        "authorResultsCount"
                    ).textContent = `Se encontraron ${results.numFound} libros del autor (mostrando ${results.docs.length})`;
                } catch (error) {
                    libraryApp.showError("Error al buscar libros del autor");
                }
            }
        });
    }
});
