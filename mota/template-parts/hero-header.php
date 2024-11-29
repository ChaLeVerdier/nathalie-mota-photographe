<?php
// Récupère une image aléatoire depuis le CPT 'photo'
$photos = new WP_Query(array(
    'post_type' => 'photo',  // Type de contenu 'photo'
    'posts_per_page' => 1,    // Limite à 1 résultat
    'orderby' => 'rand'       // Trie de manière aléatoire
));

// Vérifie si une photo est trouvée et récupère l'URL de l'image à la une
if ($photos->have_posts()) {
    $photos->the_post();
    $random_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
} else {
    // Image de remplacement si aucune photo trouvée
    $random_image_url = get_template_directory_uri() . '/assets/images/hero/default-hero.jpg';
}
wp_reset_postdata();  // Réinitialise la requête après utilisation
?>

<!-- Section Hero avec une image de fond dynamique -->
<section class="hero" style="background-image: url('<?php echo esc_url($random_image_url); ?>');">
    <div class="container-inner">
        <div class="hero-content">
            <!-- Titre affiché dans la section Hero -->
            <h1 class="hero-title"><?php echo esc_html(get_theme_mod('hero_title_text', __('Photographe event', 'mota'))); ?></h1>
        </div>
    </div>
</section>
