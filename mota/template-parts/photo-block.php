<?php

/**
 * Template part for displaying a reusable photo block.
 *
 * @package Mota
 */

$post_ids = !empty($args['post_ids']) ? $args['post_ids'] : [];

if (empty($post_ids)) {
    echo '<p>Aucune photo trouvée.</p>';
    return;
}

foreach ($post_ids as $post_id) :
    $title = get_the_title($post_id);
    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'gallery-thumbnail') ?: 'default-thumbnail.jpg'; // Ajoute un fallback
    $reference = get_post_meta($post_id, 'Reference', true);
    $categories = get_the_terms($post_id, 'photo-categorie');
    $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Aucune catégorie';
?>

    <div class="photo-block__container">
        <!-- Image de la photo -->
        <div class="photo-thumbnail">

            <img
                class="photo-block__img open-lightbox"
                src="<?php echo esc_url($thumbnail_url); ?>"
                alt="<?php echo esc_attr($title); ?>"
                data-title="<?php echo esc_attr($title); ?>"
                data-thumbnail="<?php echo esc_url($thumbnail_url); ?>"
                data-reference="<?php echo esc_attr($reference); ?>"
                data-category="<?php echo esc_attr($category_name); ?>" />

            <!-- Superposition -->
            <div class="photo-overlay">
                <!-- Icône de lightbox en haut à droite -->
                <a
                    href="<?php echo esc_url($thumbnail_url); ?>"
                    class="photo-overlay__fullscreen lightbox-trigger"
                    data-img="<?php echo esc_url($thumbnail_url); ?>" 
                    data-title="<?php echo esc_attr($title); ?>"
                    data-reference="<?php echo esc_attr($reference); ?>"
                    data-category="<?php echo esc_attr($category_name); ?>">
                    <img
                        src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/fullscreen.svg'); ?>"
                        alt="<?php esc_attr_e('Plein écran', 'Mota'); ?>" />
                </a>

                <!-- Icône lien vers la photo au centre -->
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="photo-overlay__link">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/eye.svg'); ?>" alt="<?php esc_attr_e('Voir la photo', 'Mota'); ?>" />
                </a>

                <!-- Informations en bas : Référence et Catégorie -->
                <div class="photo-overlay__info">
                    <p class="photo-overlay__reference"><?php echo esc_html($reference); ?></p>
                    <p class="photo-overlay__category"><?php echo esc_html($category_name); ?></p>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>