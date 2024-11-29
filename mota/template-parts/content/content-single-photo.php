<?php

/**
 * Template part pour l'affichage d'une photo
 *
 * @package Mota
 */

// Récupération des valeurs ACF
$reference = get_field('Reference', get_the_ID()) ?: ''; // Récupère la référence associée à la photo ou retourne une chaîne vide si non définie
$type = get_field('Type', get_the_ID()) ?: ''; // Récupère le type associé à la photo ou une chaîne vide

// Récupération de l'année de publication
$annee = get_the_date('Y') ?: ''; // Récupère l'année de publication ou une chaîne vide si non définie

// Récupération des termes de taxonomie
$categories = get_the_terms(get_the_ID(), 'photo-categorie') ?: []; // Récupère les catégories de la photo ou un tableau vide
$formats = get_the_terms(get_the_ID(), 'photo-format') ?: []; // Récupère les formats associés à la photo ou un tableau vide

// URL de la page de contact
$contact_page_url = get_permalink(get_page_by_path('contact')) ?: '#'; // Définit une URL de fallback si la page de contact n'existe pas

// Debug : Affichage des valeurs pour vérifier leur contenu
/*
var_dump($reference); // Vérifie si la référence est correctement récupérée (string ou null)
var_dump($type);      // Vérifie le type récupéré (string ou null)
var_dump($annee);     // Vérifie l'année de publication (string ou null)
var_dump($categories); // Vérifie les catégories (array ou WP_Error)
var_dump($formats);    // Vérifie les formats (array ou WP_Error)
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-single-photo'); ?>>
    <header class="photo-header">
        <div class="photo-info">
            <?php the_title('<h1 class="photo-title">', '</h1>'); ?>

            <!-- Vérifie si des informations spécifiques existent pour la photo -->
            <?php if ($reference || $type || $annee) : ?>
                <div class="photo-details">
                    <?php if ($reference) : ?>
                        <p class="photo-reference">Référence : <?php echo esc_html($reference); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($categories)) : ?>
                        <p class="photo-categorie">Catégorie :
                            <?php echo esc_html(implode(', ', wp_list_pluck($categories, 'name'))); ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($formats)) : ?>
                        <p class="photo-format">Format :
                            <?php echo esc_html(implode(', ', wp_list_pluck($formats, 'name'))); ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($type) : ?>
                        <p class="photo-type">Type : <?php echo esc_html($type); ?></p>
                    <?php endif; ?>
                    <?php if ($annee) : ?>
                        <p class="photo-annee">Année : <?php echo esc_html($annee); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Affiche l'image principale de la photo -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="photo-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
    </header>

    <!-- Section de contact et navigation -->
    <section class="photo-contact-section">
        <div class="photo-question">
            <p>Cette photo vous intéresse ?</p>
            <?php if ($reference) : ?>
                <!-- Bouton de contact avec référence intégrée -->
                <button id="contact-btn" class="load-more-btn open-modal" data-reference="<?php echo esc_attr($reference); ?>">
                    Contact
                </button>
            <?php endif; ?>
        </div>

        <div class="photo-navigation">
            <div class="nav-links">
                <?php
                // Navigation vers les articles précédent et suivant
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>

                <!-- Lien vers l'article précédent -->
                <?php if ($prev_post) : ?>
                    <div class="nav-item previous-photo">
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link prev-link">
                            <?php $prev_thumbnail = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>
                            <?php if ($prev_thumbnail) : ?>
                                <div class="thumbnail-preview">
                                    <img src="<?php echo esc_url($prev_thumbnail); ?>" />
                                </div>
                            <?php endif; ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-left.svg" alt="Flèche gauche" class="arrow-icon">
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Lien vers l'article suivant -->
                <?php if ($next_post) : ?>
                    <div class="nav-item next-photo">
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link next-link">
                            <?php $next_thumbnail = get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>
                            <?php if ($next_thumbnail) : ?>
                                <div class="thumbnail-preview">
                                    <img src="<?php echo esc_url($next_thumbnail); ?>" />
                                </div>
                            <?php endif; ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-right.svg" alt="Flèche droite" class="arrow-icon">
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section "Vous aimerez aussi" -->
    <section class="related-photos">
        <h2 class="related-title">Vous aimerez aussi</h2>
        <div class="gallery">
        <?php
        // Recherche des photos similaires basées sur les catégories
        if (!empty($categories)) {
            $category_slugs = wp_list_pluck($categories, 'slug');

            $related_posts_query = new WP_Query(array(
                'post_type'      => 'photo',
                'posts_per_page' => 2,
                'post__not_in'   => array(get_the_ID()),
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'photo-categorie',
                        'field'    => 'slug',
                        'terms'    => $category_slugs,
                    ),
                ),
                'orderby'        => 'rand',
                'fields'         => 'ids',
            ));

            $related_post_ids = $related_posts_query->posts;

            if (!empty($related_post_ids)) {
                get_template_part('template-parts/photo-block', null, array('post_ids' => $related_post_ids));
            } else {
                echo '<p>Aucune photo similaire trouvée.</p>';
            }

            wp_reset_postdata();
        } else {
            echo '<p>Aucune catégorie associée à cette photo.</p>';
        }
        ?>
        </div>
    </section>
</article>

<?php get_footer(); ?>
