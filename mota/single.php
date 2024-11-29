<?php

/**
 * Fichier d'affichage d'un article individuel
 * Ce fichier est utilisé pour afficher le contenu d'un article unique.
 * Il est conçu pour être facile à personnaliser et à étendre selon les besoins du projet.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Mota
 * @since Mota 1.0
 */

get_header();
?>

<?php
while (have_posts()) :
    the_post();
    //  Affichage du contenu de l'article
    get_template_part('template-parts/content/content', 'single');
endwhile;

// Ajoute la navigation entre les photos (posts)
the_post_navigation(
    array(
        'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'mota') . '</span>',
        'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'mota') . '</span>',
    )
);
