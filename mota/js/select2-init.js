jQuery(document).ready(function ($) {
    // Appliquer Select2 au menu déroulant
    $('#photo-categorie, #photo-format, #sort_by_date').select2({
        placeholder: function () {
            // Placeholder dynamique
            return $(this).attr('placeholder');
        },
        allowClear: true, // Bouton pour effacer la sélection
        minimumResultsForSearch: 5, // Active la barre de recherche si plus de 5 options
    });

    console.log('Select2 initialisé sur tous les filtres');
});
