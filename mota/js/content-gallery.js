// Filtre gallery 
document.addEventListener("DOMContentLoaded", function () {
    const selectElements = document.querySelectorAll("select");

    selectElements.forEach(select => {
        select.addEventListener("mouseover", (event) => {
            const options = event.target.options;
            for (let i = 0; i < options.length; i++) {
                options[i].onmouseover = function() {
                    this.style.backgroundColor = "red";
                    this.style.color = "white";
                };
                options[i].onmouseleave = function() {
                    this.style.backgroundColor = "";
                    this.style.color = "";
                };
            }
        });
    });
});
console.log('content-gallery.js chargé avec succès');

// Fonction LOAD-MORE avec jQuery et AJAX

jQuery(document).ready(function($){
    var page = 1; // Page courante, commence à 1

    $('#load-more-btn').on('click', function(e){
        e.preventDefault();
        
        var button = $(this);
        var data = {
            'action': 'load-more', // L'action à exécuter côté PHP
            'page': page // Page courante pour WP_Query
        };

        $.ajax({
            url: load_more_params.ajaxurl, // URL définie dans wp_localize_script
            data: data,
            type: 'POST',
            beforeSend: function(){
                button.text('Chargement...'); // Message de chargement
            },
            success: function(response){
                if(response === 'no more posts'){
                    button.text('Charger plus'); // Si plus de photos à charger
                    button.prop('disabled', true); // Désactiver le bouton
                } else {
                    $('.photo-gallery').append(response); // Ajouter les nouvelles images
                    button.text('Charger plus');
                    page++; // Incrémenter le compteur de pages
                }
            }
        });
    });
});


