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
?>

<?php get_header(); ?>

<main class="single-photo">

<?php
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/content', 'single-photo');
    endwhile;
    ?>

        <!-- Navigation entre les photos -->
        <div class="photo-navigation">
            <div class="previous-photo"><?php previous_post_link('%link', '← Photo précédente'); ?></div>
            <div class="next-photo"><?php next_post_link('%link', 'Photo suivante →'); ?></div>
        </div>
    </div>

    <!-- Affichage des photos apparentées -->
    <div class="related-photos">
        <?php get_template_part('template-parts/photo-block'); ?>
    </div>
</main>

<?php get_footer(); ?>
