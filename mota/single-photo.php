<?php
/**
 * Template pour l'affichage des articles de type "photo"
 *
 * Ce fichier est utilisé pour afficher le contenu d'un article unique de type "photo".
 * Il permet de personnaliser l'affichage de chaque photo selon les besoins du projet.
 *
 * @package Mota
 */

get_header();  // Inclusion du header du thème
?>

<main id="primary" class="site-main">
    <?php
    // Boucle WP : On vérifie s'il y a des articles à afficher
    while ( have_posts() ) :
        the_post(); // Prépare l'article courant pour l'affichage

        // Inclusion du template spécifique pour afficher une photo individuelle
        get_template_part( 'template-parts/content/content', 'single-photo' );

    endwhile; // Fin de la boucle d'affichage des posts.
    ?>

</main><!-- #primary -->

<?php
get_footer();  // Inclusion du footer du thème
?>

