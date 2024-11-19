<!-- Contenu Principal -->
<div class="container">
    <div class="container-inner">

        <!-- <section class="gallery"> -->

        <!-- FILTRES -->

        <!-- Ajout de la section pour les champs personnalisés -->
        <div class="gallery-filters">
            <div class="filters-left">
                <!-- Filtre par catégorie -->
                <select name="photo-categorie" id="photo-category-filter" class="selected-filter">

                    <option value="" disabled selected hidden><?php esc_html_e('CATÉGORIE', 'mota'); ?></option>

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
                <select name="photo-format" id="photo-format-filter" class="selected-filter">

                    <option value="" disabled selected hidden><?php esc_html_e('FORMAT', 'mota'); ?></option>

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
                <select name="sort_by_date" id="photo-order-filter" class="selected-filter">

                    <option value="" disabled selected hidden><?php esc_html_e('TRIER PAR', 'mota'); ?></option>

                    <option value="DESC"><?php esc_html_e('à partir des plus récentes ', 'mota'); ?></option>

                    <option value="ASC"><?php esc_html_e('à partir des
                            plus anciennes', 'mota'); ?></option>

                </select>
            </div>
        </div>



        <!-- Galerie -->
        <section class="gallery" id="gallery">
            <?php
            // Requête pour récupérer les photos
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 8,
                'paged' => 1,
            );

            $photos = new WP_Query($args);

            if ($photos->have_posts()) :
                $post_ids = array(); // Crée un tableau pour stocker les IDs des posts
                while ($photos->have_posts()) : $photos->the_post();
                    $post_ids[] = get_the_ID(); // Ajouter chaque ID de post au tableau
                endwhile;

                // Inclure le template part photo_block et lui passer les IDs des posts de la galerie
                get_template_part('template-parts/photo-block', null, array('post_ids' => $post_ids));

                wp_reset_postdata();
            endif;
            ?>
        </section>

        <!-- Bouton Charger Plus -->
        <div class="load-more-container">
            <button id="load-more-btn" class="load-more-btn" data-page="2">
                <?php esc_html_e('Charger plus', 'mota'); ?>
            </button>
        </div>