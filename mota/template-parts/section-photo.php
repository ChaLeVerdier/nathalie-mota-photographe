<?php


/**
 * Template part pour afficher la section photo.
 * Ce fichier est utilisé pour afficher les filtres et la galerie de photos sur la page.
 *
 * @package Mota
 */
?>


<div class="container">
    <div class="container-inner">




        <!-- Section des filtres pour la galerie -->
        <?php
        // Récupération des catégories associées aux photos
        $categories = get_terms(array(
            'taxonomy' => 'photo-categorie', // Taxonomie pour la catégorie de photo
            'hide_empty' => true, // Ne pas afficher les catégories vides
        ));

        // Récupération des formats associés aux photos
        $formats = get_terms(array(
            'taxonomy' => 'photo-format', // Taxonomie pour le format de photo
            'hide_empty' => true, // Ne pas afficher les formats vides
        ));
        ?>

        <div class="gallery-filters">
            <div class="filters-left">
                <!-- Filtre par catégorie -->
                <div class="custom-select filter-categorie">
                    <div class="custom-selected" data-value=""><?php esc_html_e('CATÉGORIE', 'mota'); ?></div>
                    <div class="custom-options">
                        <div class="custom-option" data-value=""><?php esc_html_e('CATÉGORIE', 'mota'); ?></div>
                        <?php if (!is_wp_error($categories) && !empty($categories)) :
                            foreach ($categories as $category) : ?>
                                <div class="custom-option" data-value="<?php echo esc_attr($category->slug); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>

                <!-- Filtre par format -->
                <div class="custom-select filter-format">
                    <div class="custom-selected" data-value=""><?php esc_html_e('FORMAT', 'mota'); ?></div>
                    <div class="custom-options">
                        <div class="custom-option" data-value=""><?php esc_html_e('FORMAT', 'mota'); ?></div>
                        <?php if (!is_wp_error($formats) && !empty($formats)) :
                            foreach ($formats as $format) : ?>
                                <div class="custom-option" data-value="<?php echo esc_attr($format->slug); ?>">
                                    <?php echo esc_html($format->name); ?>
                                </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>

            <div class="filters-right">
                <!-- Filtre de tri -->
                <div class="custom-select filter-date">
                    <div class="custom-selected" data-value=""><?php esc_html_e('TRIER PAR', 'mota'); ?></div>
                    <div class="custom-options">
                        <div class="custom-option" data-value="DESC"><?php esc_html_e('À partir des plus récentes', 'mota'); ?></div>
                        <div class="custom-option" data-value="ASC"><?php esc_html_e('À partir des plus anciennes', 'mota'); ?></div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Section Galerie : Affichage des photos -->
        <section class="gallery" id="gallery">
            <?php
            // On prépare la requête pour récupérer les photos
            $args = array(
                'post_type' => 'photo', // On spécifie que ce sont des articles de type "photo"
                'posts_per_page' => 8,  // On limite le nombre de photos affichées à 8
                'paged' => 1,           // Page actuelle pour la pagination
            );


            // Exécution de la requête WP
            $photos = new WP_Query($args);


            // Si des photos sont disponibles, on les affiche
            if ($photos->have_posts()) :
                $post_ids = array(); // Tableau pour stocker les IDs des photos
                while ($photos->have_posts()) : $photos->the_post();
                    // Ajout de l'ID de la photo au tableau
                    $post_ids[] = get_the_ID();
                endwhile;


                // On inclut le template part pour afficher les photos
                get_template_part('template-parts/photo-block', null, array('post_ids' => $post_ids));


                // On réinitialise la requête après l'affichage des photos
                wp_reset_postdata();
            else :
                // Message si aucune photo n'est trouvée
                echo '<p>' . esc_html__('Aucune photo disponible.', 'mota'); ?></p>
            <?php endif; ?>
        </section>


        <!-- Bouton pour charger plus de photos si la galerie contient plus d'une page -->
        <?php if ($photos->max_num_pages > 1) : ?>
            <div class="load-more-container">
                <button id="load-more-btn" class="load-more-btn" data-page="2" aria-live="polite">
                    <?php esc_html_e('Charger plus', 'mota'); ?>
                </button>
            </div>
        <?php endif; ?>


    </div>
</div>