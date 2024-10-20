<?php

/**
 * Hero de l'en-tête de notre thème
 *
 * Ce modèle affiche toute la section <head> et tout jusqu'à <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mota
 */
?>

<?php

// En construction

get_header(); ?>

<main id="primary" class="site-main">
    <section class="hero">

        <img src="<?php echo get_theme_mod('hero_image'); ?>" alt="Image Hero" class="hero-image hero-background">
        <div class="hero-title">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero_titre.png" alt="Titre du site">
</div>
    </section>

</main>

<?php get_footer(); ?>

