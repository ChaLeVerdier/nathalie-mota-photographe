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
while ( have_posts( ) ) : 
     the_post(); 
     // Prépare l'article courant pour l'affichage
     get_template_part( 'template-parts/content/content', 'single' ); 
 endwhile;

 // Ajouter de la navigation entre les photos
the_post_navigation(
     array(
         'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'mota') . '</span>',
         'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'mota') . '</span>',
     )
 );