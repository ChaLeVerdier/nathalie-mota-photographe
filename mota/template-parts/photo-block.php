<?php

/**
 * Template part pour afficher un bloc photo réutilisable.
 * Ce fichier est utilisé pour afficher chaque photo dans la galerie avec ses informations associées.
 *
 * @package Mota
 */

// Récupérer les identifiants des posts à afficher, transmis via $args
$post_ids = !empty($args['post_ids']) ? $args['post_ids'] : [];  // Si 'post_ids' est vide, on utilise un tableau vide

// Si aucun identifiant de post n'est trouvé, on affiche un message d'erreur
if (empty($post_ids)) {
    echo '<p>' . esc_html__('Aucune photo trouvée.', 'Mota') . '</p>';
    return; // Arrêter l'exécution du code si aucune photo n'est à afficher
}

// Boucle pour afficher chaque photo à partir de ses ID
foreach ($post_ids as $post_id) :
    // Récupérer le titre de la photo
    $title = get_the_title($post_id);
    // Récupérer l'URL de l'image à utiliser comme miniature (si disponible), sinon une image par défaut
    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'gallery-thumbnail') ?: 'default-thumbnail.jpg'; // Fallback à 'default-thumbnail.jpg' si l'image n'existe pas
    // Récupérer la référence de la photo (métadonnée), ou afficher "Non disponible" si non définie
    $reference = get_post_meta($post_id, 'Reference', true) ?: __('Non disponible', 'Mota');
    // Récupérer les catégories associées à la photo
    $categories = get_the_terms($post_id, 'photo-categorie');
    // Si des catégories existent, les afficher sous forme de chaîne (séparées par des virgules)
    $category_names = !empty($categories) ? implode(', ', wp_list_pluck($categories, 'name')) : __('Aucune catégorie', 'Mota');
    // Utiliser le titre de l'image comme texte alternatif (alt), ou "Image sans titre" si aucun titre n'est défini
    $alt_text = $title ?: __('Image sans titre', 'Mota');
    ?>

    <!-- Conteneur de la photo avec un attribut data-id pour l'identifier -->
    <div class="photo-block__container" data-id="<?php echo esc_attr($post_id); ?>">
        
        <!-- Affichage de l'image miniature de la photo -->
        <div class="photo-thumbnail">
            <img
                class="photo-block__img"
                src="<?php echo esc_url($thumbnail_url); ?>"
                alt="<?php echo esc_attr($alt_text); ?>"
                loading="lazy"  
                data-id="<?php echo esc_attr($post_id); ?>"
                data-title="<?php echo esc_attr($title); ?>"
                data-img="<?php echo esc_url($thumbnail_url); ?>"
                data-reference="<?php echo esc_attr($reference); ?>"
                data-category="<?php echo esc_attr($category_names); ?>" />

            <!-- Superposition d'éléments supplémentaires lorsque l'utilisateur survole l'image -->
            <div class="photo-overlay">
                
                <!-- Icône pour ouvrir la photo en plein écran (lightbox) -->
                <a
                    href="#"
                    class="photo-overlay__fullscreen open-lightbox"
                    data-id="<?php echo esc_attr($post_id); ?>"
                    data-img="<?php echo esc_url($thumbnail_url); ?>"
                    data-title="<?php echo esc_attr($title); ?>"
                    data-reference="<?php echo esc_attr($reference); ?>"
                    data-category="<?php echo esc_attr($category_names); ?>">
                    <img
                        src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/fullscreen.svg'); ?>"
                        alt="<?php esc_attr_e('Plein écran', 'Mota'); ?>" />
                </a>

                <!-- Icône pour ouvrir un lien vers la page de la photo -->
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="photo-overlay__link">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/eye.svg'); ?>" alt="<?php esc_attr_e('Voir la photo', 'Mota'); ?>" />
                </a>

                <!-- Informations sur la photo (référence et catégorie) sous l'image -->
                <div class="photo-overlay__info">
                    <p class="photo-overlay__reference"><?php echo esc_html($reference); ?></p>
                    <p class="photo-overlay__category"><?php echo esc_html($category_names); ?></p>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>
