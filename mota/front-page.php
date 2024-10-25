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

<?php get_template_part('template-parts/swiper-hero'); ?>


            <!-- Ajout de la section pour les champs personnalisés -->
            <section class="photo-catalogue">
                <div class="photo-filters">
                    <div class="filters-left">
                        <!-- Filtre par catégorie -->
                        <select name="photo_category" id="photo_category">
                            <option value=""><?php esc_html_e('CATÉGORIE', 'mota'); ?></option>
                            <?php
                            // Affichage des catégories spécifiques
                            $categories = array('Mariage', 'Concert', 'Réception', 'Télévision');
                            foreach ($categories as $category_slug) {
                                $category = get_term_by('slug', $category_slug, 'category');
                                if ($category) {
                                    echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
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

                <section class="photo-gallery">
                    <div id="photo-container"></div>
                    <button id="charger-plus"><?php esc_html_e('Charger plus', 'mota'); ?></button>
                </section>
            </section>

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
