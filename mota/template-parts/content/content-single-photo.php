<?php

/**
 * Template part for displaying single photo content
 *
 * @package MotaPhoto
 */

// Récupération des valeurs ACF
$reference = get_field('Reference', get_the_ID()) ?: ''; // Initialiser avec une chaîne vide
$type = get_field('Type', get_the_ID()) ?: ''; // Initialiser avec une chaîne vide

// Récupération de l'année de publication
$annee = get_the_date('Y') ?: ''; // Initialiser avec une chaîne vide

// Récupération des termes de taxonomie
$categories = get_the_terms(get_the_ID(), 'photo-categorie') ?: [];
$formats = get_the_terms(get_the_ID(), 'photo-format') ?: [];

// URL de la page de contact
$contact_page_url = get_permalink(get_page_by_path('contact')) ?: '#'; // Lien de fallback si la page n'existe pas

// Debug : Affichage des valeurs pour vérification
/*
var_dump($reference); // Affiche la référence ou NULL si non défini
var_dump($type);      // Affiche le type ou NULL si non défini
var_dump($annee);     // Affiche l'année de publication
var_dump($categories); // Affiche les catégories ou WP_Error si non trouvées
var_dump($formats);    // Affiche les formats ou WP_Error si non trouvés
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-single-photo'); ?>>
    <header class="photo-header">
        <div class="photo-info">
            <?php the_title('<h1 class="photo-title">', '</h1>'); ?>

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

        <!-- Image principale alignée à droite -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="photo-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
    </header>


    <!-- Section contact et Navigation Précédente et Suivante -->
    <section class="photo-contact-section">

        <!-- Section de contact -->
        <div class="photo-question">
            <p>Cette photo vous intéresse ?</p>
            <?php if ($reference) : ?>
                <button id="contact-btn" class="load-more-btn open-modal" data-reference="<?php echo esc_attr($reference); ?>">Contact</a>
                <?php endif; ?>
                </button>
        </div>

        <div class="photo-navigation">
            <div class="nav-links">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>

                <?php if ($prev_post) : ?>
                    <div class="nav-item previous-photo">
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link prev-link"> ← </a>
                        <?php $prev_thumbnail = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>
                        <?php if ($prev_thumbnail) : ?>
                            <div class="thumbnail-preview">
                                <img src="<?php echo esc_url($prev_thumbnail); ?>" />
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                    <div class="nav-item next-photo">
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link next-link">
                            →
                        </a>
                        <?php $next_thumbnail = get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>
                        <?php if ($next_thumbnail) : ?>
                            <div class="thumbnail-preview">
                                <img src="<?php echo esc_url($next_thumbnail); ?>" ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </section>

    <!-- Section "Vous aimerez aussi" -->
    <section class="related-photos">
        <h2 class="related-title">Vous aimerez aussi</h2>
        <div class="related-photos-grid">
            <?php
            // Récupérer les photos similaires dans la même catégorie
            $related_args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'photo-categorie',
                        'field'    => 'slug',
                        'terms'    => !empty($categories) ? wp_list_pluck($categories, 'slug') : '',
                    ),
                ),
            );
            $related_photos = new WP_Query($related_args);

            if ($related_photos->have_posts()) :
                while ($related_photos->have_posts()) : $related_photos->the_post();
            ?>
                    <div class="related-photo-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>
</article>