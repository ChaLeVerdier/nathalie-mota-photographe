<?php
// Vérifier si la catégorie de la photo actuelle est définie
if (has_term('', 'categorie')) {
    // Récupérer la catégorie de la photo actuelle
    $categories = get_the_terms(get_the_ID(), 'categorie');
    $category = $categories[0];

    // Requête wp_query pour récupérer les articles de la même catégorie
    $related_photos_query = new WP_Query( array(
        'post_type' => 'photo',
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $category->slug,
            ),
        ),
        'post__not_in' => array(get_the_ID()), // Exclure la photo actuelle
        'orderby' => 'rand', // Ordre aléatoire
        'posts_per_page' => 2 // Limiter à 2 photos apparentées
    ) );

    // Vérifier si des articles ont été trouvés
    if ( $related_photos_query->have_posts() ) {
        echo '<div class="related-photos">';
        echo '<h2>Vous aimerez aussi</h2>';
        echo '<div class="related-photos-container">';
        
        // Parcourir les articles
        while ( $related_photos_query->have_posts() ) {
            $related_photos_query->the_post();
            // Afficher chaque photo apparentée avec le format souhaité
            ?>
            <div class="related-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php 
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('thumbnail');
                    }
                    ?>
                    <h3><?php the_title(); ?></h3>
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    if ($categories && !is_wp_error($categories)) {
                        echo '<p class="photo-category">' . esc_html($categories[0]->name) . '</p>';
                    }
                    ?>
                </a>
            </div>
            <?php
        }
        
        echo '</div>'; // Fermeture de .related-photos-container
        echo '</div>'; // Fermeture de .related-photos
    } else {
        // Aucun article trouvé
        echo '<p>Aucune photo apparentée trouvée.</p>';
    }

    // Réinitialiser la requête
    wp_reset_postdata();
} else {
    // Aucune catégorie définie pour la photo actuelle
    echo '<p>Cette photo n\'a pas de catégorie définie.</p>';
}
?>
