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


<main id="primary" class="site-main"><?php echo 'tout est ok'; ?>
<?php
while ( have_posts( ) ) : 
     the_post(); 
     // Prépare l'article courant pour l'affichage
     get_template_part( 'template-parts/content/content', 'single' ); 
 endwhile;

 ?>

</main>

<?php
get_footer();