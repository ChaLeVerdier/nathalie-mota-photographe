<div id="photo-lightbox" class="photo-lightbox hidden">
    <!-- Lightbox pour afficher les photos en plein écran. -->
    <!-- Ce conteneur est caché par défaut (avec la classe 'hidden') et devient visible lors de l'interaction avec l'utilisateur. -->
    
    <div class="photo-lightbox__content">
        <!-- Le contenu principal de la lightbox, incluant l'image et les boutons de navigation. -->

        <!-- Bouton de fermeture de la lightbox -->
        <span class="photo-lightbox__close">&times;</span>
        <!-- Ce bouton permet à l'utilisateur de fermer la lightbox en cliquant dessus. -->

        <!-- Image affichée dans la lightbox -->
        <img id="lightbox-image" src="" alt="Lightbox Image" />
        <!-- L'image qui est affichée dans la lightbox sera dynamique, remplie via JS en fonction de l'image sélectionnée. -->

        <!-- Navigation entre les photos -->
        <button id="prev-photo" class="photo-lightbox__prev">
            <!-- Le bouton précédent permet de naviguer vers la photo précédente. -->
            <img
                src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/arrow-left-white.svg'); ?>"
                alt="<?php esc_attr_e('Précédent', 'mota'); ?>" />
            <!-- Utilisation d'une flèche gauche (icône) pour indiquer la navigation vers la photo précédente. -->
        </button>
        
        <button id="next-photo" class="photo-lightbox__next">
            <!-- Le bouton suivant permet de naviguer vers la photo suivante. -->
            <img
                src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/arrow-right-white.svg'); ?>"
                alt="<?php esc_attr_e('Suivant', 'mota'); ?>" />
            <!-- Utilisation d'une flèche droite (icône) pour indiquer la navigation vers la photo suivante. -->
        </button>

        <!-- Informations supplémentaires sur la photo -->
        <div class="photo-lightbox__info">
            <p id="lightbox-reference"></p>
            <!-- Affichage de la référence de la photo, à remplir via JS avec les données de la photo affichée. -->
            <p id="lightbox-category"></p>
            <!-- Affichage de la catégorie de la photo, également rempli via JS. -->
        </div>
    </div>
</div>
