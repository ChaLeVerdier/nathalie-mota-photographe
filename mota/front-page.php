<?php

/**
 * Hero de l'en-tête 
 *
 * @package Mota
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
    ?>
<section class='hero'>
<div class="hero">
    <div class="hero-background-image">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero2.png'); ?>" alt="Image Hero">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-titre.png" alt="Titre du Hero" class="hero-title">
    </div>
</div>
</section>

<!-- // Section catalogue 1e partie : filtres -->
            <section class="catalogue">
                
                <!-- Ajout de la section pour les champs personnalisés -->
                <div class="catalogue-filters">
                    <div class="filters-left">
                        <!-- Filtre par catégorie -->
                        <select name="photo-categorie" id="photo-categorie">
                            <option value=""><?php esc_html_e('CATÉGORIE', 'mota'); ?></option>
                            <?php
                            // Affichage des catégories spécifiques
                            $categories = array('mariage', 'concert', 'Reception', 'Television');
                            foreach ($categories as $categorie_slug) {
                                $categorie = get_term_by('slug', $categorie_slug, 'category');
                                if ($categorie) {
                                    echo '<option value="' . esc_attr($categorie->slug) . '">' . esc_html($categorie->name) . '</option>';
                                }
                            }
                            ?>
                        </select>

                        <!-- Filtre par format -->
                        <select name="photo_format" id="photo_format">
                            <option value=""><?php esc_html_e('FORMAT', 'mota'); ?></option>
                            <?php
                            // Affichage des formats spécifiques
                            $formats = array('portrait', 'paysage');
                            foreach ($formats as $format_slug) {
                                $format = get_term_by('slug', $format_slug, 'format');
                                if ($format) {
                                    echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filters-right">
                        <!-- Trier par date -->
                        <select name="sort_by_date" id="sort_by_date">
                            <option value=""><?php esc_html_e('TRIER PAR', 'mota'); ?></option>
                            <option value="asc"><?php esc_html_e('Du plus ancien au plus récent', 'mota'); ?></option>
                            <option value="desc"><?php esc_html_e('Du plus récent au plus ancien', 'mota'); ?></option>
                        </select>
                    </div>
                </div>

                <!-- Inclusion de la galerie -->
                <?php get_template_part('template-parts/content', 'gallery'); ?>
                

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content();
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'mota'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>
            <?php
        endwhile;

        // Articles récents
        $recent_posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 3,
        ));

        if ($recent_posts->have_posts()) :
            ?>
                <section class="recent-posts">
                    <h2><?php esc_html_e('Articles Récents', 'mota'); ?></h2>
                    <?php
                    while ($recent_posts->have_posts()) :
                        $recent_posts->the_post();
                        get_template_part('template-parts/content/content', 'excerpt');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </section>
        <?php
        endif;

    else :
        get_template_part('template-parts/content/content', 'none');
    endif;
        ?>
</main>

<?php
get_sidebar();
get_footer();
