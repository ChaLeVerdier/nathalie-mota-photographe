jQuery(document).ready(function ($) {
    let page = 2; // Commence à la page 2
    const loadMoreButton = $("#load-more-btn");
    const galleryContainer = $("#gallery");

    loadMoreButton.on("click", function () {
        loadMoreButton.prop("disabled", true); // Désactive temporairement le bouton

        $.ajax({
            url: load_more_params.ajax_url,
            type: "POST",
            data: {
                action: "load_more_photos",
                page: page,
                nonce: load_more_params.nonce,
            },
            success: function (response) {
                if (response.success && response.data.html) {
                    galleryContainer.append(response.data.html); // Ajoute les nouvelles photos
                    page++; // Passe à la page suivante
                    $(document).trigger("photosUpdated"); // Notifie que les nouvelles photos sont disponibles
                }
                if (page > load_more_params.max_pages) {
                    loadMoreButton.hide(); // Cache le bouton si toutes les pages sont chargées
                }
                loadMoreButton.prop("disabled", false); // Réactive le bouton
            },
            error: function () {
                console.error("Erreur lors du chargement des photos.");
                loadMoreButton.prop("disabled", false); // Réactive le bouton même en cas d'erreur
            },
        });
    });
});
