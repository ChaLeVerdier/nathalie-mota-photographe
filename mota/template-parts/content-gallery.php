<!-- // Section catalogue 2e partie : gallerie -->

<section id="photo-gallery">
    <div class="gallery">
        <?php
        // Arguments pour récupérer les images
        $args = array(
            'post_type' => 'photo', 
            'posts_per_page' => 8, 
            'page'=> 1,
        );

        $photos = new WP_Query($args);

        if ($photos->have_posts()) :
            while ($photos->have_posts()) : $photos->the_post();
        ?>
                
            <div class="gallery-item">
                <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('gallery-thumbnail'); ?>
                        </a>
                <?php endif; ?>
            </div>

            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
    </div>
</section>



<!-- Bouton Charger Plus -->
<div class="load-more-container">
            <button id="load-more-btn" class="load-more-btn" data-page="2"><?php esc_html_e('Charger plus', 'mota'); ?></button>
        </div>
