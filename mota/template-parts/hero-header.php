<?php
// Récupérer une image aléatoire depuis le CPT 'photo'
$photos = new WP_Query(array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'orderby' => 'rand'
));

if ($photos->have_posts()) {
    $photos->the_post();
    // Récupérer l'URL de l'image à la une
    $random_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
} else {
    // Image de fallback si aucune photo n'est trouvée
    $random_image_url = get_template_directory_uri() . '/assets/images/hero/default-hero.jpg';
}
wp_reset_postdata();
?>

<!-- Hero Section -->
<section class="hero" style="background-image: url('<?php echo esc_url($random_image_url); ?>');">
    <div class="container-inner">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html(get_theme_mod('hero_title_text', __('Photographe event', 'mota'))); ?></h1>
        </div>
    </div>
</section>

