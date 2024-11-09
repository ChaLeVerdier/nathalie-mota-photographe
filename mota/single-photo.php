<?php
/**
 * The template for displaying single photo posts
 *
 * @package MotaPhoto
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content/content', 'single-photo' );

    endwhile; // End of the loop.
    ?>

</main><!-- #main -->

<?php
get_footer();