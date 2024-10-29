<section class='hero'>
    <div class="swiper-container swiper-hero">
        <div class="swiper-wrapper">
            <?php
            // Récupérer les images de la bibliothèque de médias
            $images = get_posts(array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_mime_type' => 'image',
            ));

            // Mélanger les images pour obtenir un ordre aléatoire
            shuffle($images);
            $random_images = array_slice($images, 0, 2); // Limiter à 2 images

            foreach ($random_images as $image) : ?>
                <div class="swiper-slide" style="background-image: url('<?php echo esc_url(wp_get_attachment_url($image->ID)); ?>');"></div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="hero">
    <div class="hero-background-image">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero2.png'); ?>" alt="Image Hero">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-titre.png" alt="Titre du Hero" class="hero-title">
    </div>
</div>
</section>
