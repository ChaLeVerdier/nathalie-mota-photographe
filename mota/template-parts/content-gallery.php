<!-- // Section catalogue 2e partie : gallerie -->

<section id="photo-container">
    <div class="gallery">
        <?php
        // Arguments pour récupérer les images
        $args = array(
            'post_type' => 'photo', 
            'posts_per_page' => 8, 
            'page'=> 1,
        );

        $gallery_query = new WP_Query($args);

        if ($gallery_query->have_posts()) :
            while ($gallery_query->have_posts()) : $gallery_query->the_post(); ?>
                <div class="gallery-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(''); // Affiche l'image mise en avant 
                        ?>
                    </a>

                </div>
            <?php endwhile;
            wp_reset_postdata(); // Réinitialise la requête
        else : ?>
            <p><?php esc_html_e('Aucune image trouvée.', 'mota'); ?></p>
        <?php endif; ?>
    </div>
</section>

<button id="load-more-btn" class="load-more"><?php esc_html_e('Charger plus', 'mota'); ?></button>