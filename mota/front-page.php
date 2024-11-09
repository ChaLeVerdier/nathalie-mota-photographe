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
                            $categories = get_terms(array(
                                'taxonomy' => 'photo-categorie',
                                'hide_empty' => true,
                            ));
                            foreach ($categories as $category) {
                                echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                            }
                            ?>

                        </select>

                        <!-- Filtre par format -->
                        <select name="photo-format" id="photo-format">

                            <option value=""><?php esc_html_e('FORMAT', 'mota'); ?></option>

                            <?php
                            // Affichage des formats spécifiques
                            $formats = get_terms(array(
                                'taxonomy' => 'photo-format',
                                'hide_empty' => true,
                            ));
                            foreach ($formats as $format) {
                                echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
                            }
                            ?>

                        </select>
                    </div>

                    <div class="filters-right">
                        <!-- Trier par date -->
                        <select name="sort_by_date" id="sort_by_date">

                            <option value=""><?php esc_html_e('TRIER PAR', 'mota'); ?></option>

                            <option value="DESC"><?php esc_html_e('à partir des plus récentes ', 'mota'); ?></option>

                            <option value="ASC"><?php esc_html_e('à partir des
                            plus anciennes', 'mota'); ?></option>

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
