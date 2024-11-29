document.addEventListener('DOMContentLoaded', function () {
    const galleryContainer = document.getElementById('gallery'); // Conteneur principal de la galerie
    const loadMoreButton = document.getElementById('load-more-btn'); // Bouton "Charger plus"

    // Sélecteurs personnalisés
    const categoryFilter = document.querySelector('.filter-categorie .custom-selected'); // Filtre par catégorie
    const formatFilter = document.querySelector('.filter-format .custom-selected'); // Filtre par format
    const orderFilter = document.querySelector('.filter-date .custom-selected'); // Tri par date

    console.log('Initialisation des filtres et de la galerie');

    // Fonction pour récupérer les photos filtrées
    function fetchFilteredPhotos() {
        const category = categoryFilter ? categoryFilter.dataset.value : 'all';
        const format = formatFilter ? formatFilter.dataset.value : 'all';
        const order = orderFilter ? orderFilter.dataset.value : 'DESC';

        console.log('Valeurs des filtres :', { category, format, order });

        // Envoi des paramètres au backend
        const data = new URLSearchParams({
            action: 'filter_photos',
            category: category,
            format: format,
            order: order,
        });

        fetch(ajaxurl, {
            method: 'POST',
            body: data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
            .then((response) => {  // promesse
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                console.log('Réponse du serveur :', data);

                if (data.success && galleryContainer) {
                    galleryContainer.innerHTML = data.data.html;

                    if (loadMoreButton) {
                        loadMoreButton.dataset.page = 2;
                        loadMoreButton.dataset.maxPages = data.data.max_pages;

                        if (data.data.max_pages <= 1) {
                            loadMoreButton.style.display = 'none';
                        } else {
                            loadMoreButton.style.display = 'block';
                        }
                    }
                } else {
                    galleryContainer.innerHTML = '<p>Aucune photo trouvée.</p>';
                    if (loadMoreButton) {
                        loadMoreButton.style.display = 'none';
                    }
                }
            })
            .catch((error) => {
                console.error('Erreur lors de la requête AJAX :', error);
            });
    }

    // Charger plus de photos
    function loadMorePhotos() {
        const currentPage = parseInt(loadMoreButton.dataset.page, 10) || 1;
        const maxPages = parseInt(loadMoreButton.dataset.maxPages, 10) || 1;

        if (currentPage > maxPages) {
            return;
        }

        const category = categoryFilter ? categoryFilter.dataset.value : 'all';
        const format = formatFilter ? formatFilter.dataset.value : 'all';
        const order = orderFilter ? orderFilter.dataset.value : 'DESC';

        const data = new URLSearchParams({
            action: 'filter_photos',
            category: category,
            format: format,
            order: order,
            page: currentPage,
        });

        fetch(ajaxurl, {
            method: 'POST',
            body: data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success && galleryContainer) {
                    galleryContainer.innerHTML += data.data.html;
                    loadMoreButton.dataset.page = currentPage + 1;

                    if (currentPage + 1 > maxPages) {
                        loadMoreButton.style.display = 'none';
                    }
                } else {
                    console.log('Aucune photo supplémentaire trouvée.');
                    loadMoreButton.style.display = 'none';
                }
            })
            .catch((error) => {
                console.error('Erreur lors du chargement des photos supplémentaires :', error);
            });
    }

    // Ajout des événements de clic sur les filtres personnalisés
    const customFilters = document.querySelectorAll('.custom-option');
    customFilters.forEach(option => {
        option.addEventListener('click', function () {
            const selected = this.closest('.custom-select').querySelector('.custom-selected');
            selected.textContent = this.textContent;
            selected.dataset.value = this.dataset.value;

            // Appliquer les filtres après sélection
            fetchFilteredPhotos();
        });
    });

    // Bouton "Charger plus"
    if (loadMoreButton) loadMoreButton.addEventListener('click', loadMorePhotos);
});
