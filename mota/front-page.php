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
                <?php
                //ajoute template-parts hero.php
                $template_part = locate_template('template-parts/hero-header.php');
                if ($template_part) {
                    get_template_part('template-parts/hero-header');
                } else {
                    // Code alternatif si le template part n'existe pas
                    echo '<p>Le template hero est indisponible.</p>';
                }
                ?>
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
                </section>
                <!-- Inclusion de la galerie -->
                <?php get_template_part('template-parts/content', 'gallery'); ?>


                
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
