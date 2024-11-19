jQuery(document).ready(function($) {
    let page = 2; // Commence à la page 2, car la page 1 est déjà chargée
    const loadMoreButton = $("#load-more-btn");
    const galleryContainer = $("#gallery");

    loadMoreButton.on("click", function() {
        console.log("URL AJAX :", load_more_params.ajax_url); // Vérification de l'URL
        console.log("Page à charger :", page); // Vérification de la page

        // Prépare les données pour la requête
        const data = {
            action: "load_more_photos",
            page: page,
            nonce: load_more_params.nonce // Si un nonce est utilisé pour la sécurité
        };

        // Envoie la requête AJAX avec jQuery
        $.ajax({
            url: load_more_params.ajax_url,
            type: "POST",
            data: data,
            success: function(response) {
                console.log("Réponse du serveur :", response); // Affiche la réponse reçue
                if (response) {
                    galleryContainer.append(response); // Ajoute la réponse au conteneur de la galerie
                    page++;

                    // Si on atteint la dernière page, on cache le bouton
                    if (page > load_more_params.max_pages) {
                        loadMoreButton.hide();
                    }
                } else {
                    loadMoreButton.hide();
                }
            },
            error: function(error) {
                console.error("Une erreur s'est produite lors du chargement des photos :", error);
            }
        });
    });
});
