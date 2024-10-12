<?php

/**
 * The template for displaying all single posts
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
// utilisation de la "WordPress loop" pour gérer l'affichage dynamique du contenu.
 while ( have_posts( ) ) : 
     the_post(); 
     // Prépare l'article courant pour l'affichage
     get_template_part( 'template-parts/content/content', 'page' ); 
 endwhile;

get_footer();
