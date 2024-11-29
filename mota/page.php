<?php
/**
 * Template pour l'affichage des pages
 * 
 * Ce fichier gère l'affichage des pages statiques (comme "À propos", "Contact", etc.) sur le site.
 * Il fait appel à la boucle WP pour afficher le contenu de la page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Mota
 * @since Mota 1.0
 */

 get_header(); // Inclusion du header du site
?>

<?php
// Démarrage de la boucle WP pour récupérer et afficher le contenu de la page.
while ( have_posts() ) : 
    the_post(); 
    // Récupère et affiche le contenu de la page en utilisant le template approprié ici "content-page.php".
    get_template_part( 'template-parts/content/content', 'page' ); 
endwhile; // Fin de la boucle

get_footer(); // Inclusion du footer du site


