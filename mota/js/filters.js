// Description: Script JavaScript pour filtrer les photos de la galerie en utilisant AJAX
document.addEventListener('DOMContentLoaded', function () {
    const categoryFilter = document.getElementById('photo-category-filter');
    const formatFilter = document.getElementById('photo-format-filter');
    const orderFilter = document.getElementById('photo-order-filter');
    const galleryContainer = document.getElementById('gallery');

    // Vérification initiale des éléments
    console.log('Chargement des éléments de filtre :');
    console.log('Catégorie :', categoryFilter ? 'Trouvé' : 'Non trouvé');
    console.log('Format :', formatFilter ? 'Trouvé' : 'Non trouvé');
    console.log('Ordre :', orderFilter ? 'Trouvé' : 'Non trouvé');
    console.log('Galerie :', galleryContainer ? 'Trouvé' : 'Non trouvé');

    function fetchFilteredPhotos() {
        // Assurez-vous que les éléments existent avant d'essayer de récupérer leur valeur
        const category = categoryFilter ? categoryFilter.value : '';
        const format = formatFilter ? formatFilter.value : '';
        const order = orderFilter ? orderFilter.value : '';

        // Log des valeurs des filtres pour vérifier leur récupération
        console.log('Valeurs des filtres :');
        console.log('Filtre catégorie:', category);
        console.log('Filtre format:', format);
        console.log('Ordre de tri:', order);

        // Création de l'objet de données pour AJAX
        const data = new URLSearchParams({
            action: 'filter_photos',
            category: category,
            format: format,
            order: order,
        });

        console.log('Données envoyées via AJAX:', Object.fromEntries(data)); // Vérifie les données envoyées

        fetch(ajaxurl, {
            method: 'POST',
            body: data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
            .then((response) => {
                console.log('Réponse brute:', response); // Vérifie l'objet de réponse
                return response.text();
            })
            .then((data) => {
                console.log('Données reçues du serveur:', data); // Vérifie le HTML renvoyé par le serveur
                if (galleryContainer) {
                    galleryContainer.innerHTML = data;
                } else {
                    console.log('Erreur : Élément de galerie introuvable pour afficher les données.');
                }
            })
            .catch((error) => {
                console.error('Erreur lors du filtrage des photos:', error);
            });
    }

    // Ajout des écouteurs d'événements si les éléments existent
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            console.log('Changement de catégorie détecté');
            fetchFilteredPhotos();
        });
    } else {
        console.log('Aucun écouteur ajouté pour le filtre de catégorie, élément introuvable.');
    }

    if (formatFilter) {
        formatFilter.addEventListener('change', function() {
            console.log('Changement de format détecté');
            fetchFilteredPhotos();
        });
    } else {
        console.log('Aucun écouteur ajouté pour le filtre de format, élément introuvable.');
    }

    if (orderFilter) {
        orderFilter.addEventListener('change', function() {
            console.log('Changement d\'ordre détecté');
            fetchFilteredPhotos();
        });
    } else {
        console.log('Aucun écouteur ajouté pour le filtre d\'ordre, élément introuvable.');
    }
});
