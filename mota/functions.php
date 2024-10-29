<?php
/**
 * Fonctions et définitions du thème
 *
 * @package mota
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

if (!defined('ABSPATH')) {
    exit; // Sortie si accédé directement
}

// Gère la version du thème, bonne pratique pour les mises à jour
if ( ! defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '1.0.0' );
}

// Thème multilingue
load_theme_textdomain('mota', get_template_directory() . '/languages');

// Restreindre l'accès aux utilisateurs administrateurs
function restrict_access_to_admin_only() {
    if ( !current_user_can( 'administrator' ) && is_admin() ) {
        wp_redirect( home_url() );  // Redirige les utilisateurs non-administrateurs vers la page d'accueil
        exit;
    }
}
// Hook pour restreindre l'accès au back-office aux non-administrateurs
add_action( 'template_redirect', 'restrict_access_to_admin_only' );


// *********************************************** //
// *********** Chargement des scripts ************ //
// *********************************************** //


// Chargement des styles
function mota_enqueue_styles() {
    wp_enqueue_style('mota-main-style', get_template_directory_uri() . '/assets/css/main.css');
}

// Chargement des scripts
function mota_enqueue_scripts() {
    // Création d'un Swiper pour le hero
    // Enqueue Swiper CSS 
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');

    // Enqueue Swiper JS
    wp_enqueue_script('hero-swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array('jquery'), null, true);

    // Enqueue votre script principal, dépendant de Swiper
    wp_enqueue_script('mota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery', 'hero-swiper-js'), '1.0.0', true);

    // Enqueue le script pour charger plus de photos
    // wp_enqueue_script('load-more-photos', get_stylesheet_directory_uri() . '/js/load-more.js', array('jquery'), null, true);
}


// *********************************************** //
// *********** Load-more avec Ajax *************** //
// *********************************************** //

function load_more_gallery_scripts() {
    wp_enqueue_script( 'load-more-gallery', get_template_directory_uri() . '/js/content-gallery.js', array('jquery'), null, true );
    wp_localize_script( 'load-more-gallery', 'load_more_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'), // URL pour l'admin ajax
        'posts_per_page' => 8, // Nombre d'images à charger à chaque fois
        'current_page' => 1, // Page courante
    ));
}


// Gérer la requête AJAX
function load_more_gallery_images() {
    // Récupérer les paramètres de la requête AJAX
    $paged = $_POST['page'] + 1;

    // Arguments pour la requête WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

    $gallery_query = new WP_Query($args);

    if ($gallery_query->have_posts()) :
        while ($gallery_query->have_posts()) : $gallery_query->the_post(); ?>
            <div class="gallery-item">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('full', array('width' => 560, 'height' => 495)); // Image de taille 560x495 ?>
                </a>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else :
        echo 'no more posts';
    endif;

    die(); // Fin de la requête Ajax
}


// ******************************************* //
// *********** Gestion des menus ************* //
// ******************************************* //

function mota_register_menus() { // Enregistrement des menus
    register_nav_menus(
        array(
            'main-menu' => esc_html__('Menu Principal', 'mota'), // Menu header
            'footer-menu' => esc_html__('Menu Pied de page', 'mota'), // Menu footer
            'social-menu' => esc_html__('Menu Réseaux sociaux', 'mota'), // Menu réseaux sociaux (blog)
        )
    );
}


function add_contact_link_class($items) {
    foreach ($items as $item) {
        if ($item->title == 'Contact') {
            $item->classes[] = 'contact-link';
            
            // Ajoutez ceci pour obtenir la référence de la photo actuelle
            if (is_singular('photo')) {
                $reference = get_field('reference');
                $item->url .= '" data-photo-ref="' . esc_attr($reference);
            }
        }
    }
    return $items;
}


// ******************************************* //
// *********** Gestion des images ************* //
// ******************************************* //

// Ajouter la prise en charge des images mises en avant
add_theme_support('post_thumbnails');

// Ajouter la prise en charge de l'interface de menu classique
function enable_classic_menu_interface() {
    add_theme_support('menus');
}

// Ajouter la prise en charge des images de taille personnalisée
add_image_size('featured-thumbnail', 350, 233, true);

// Fonction pour ajouter l'attribut loading="lazy" aux images
function ajouter_lazy_loading($content) {
    return str_replace('<img', '<img loading="lazy"', $content);
}


// ******************************************* //
// ************* Hooks d'action ************** //
// ******************************************* //

add_action('wp_enqueue_scripts', 'mota_enqueue_styles');
add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');
add_action('init', 'mota_register_menus');
add_action('after_setup_theme', 'mota_register_menus');
add_action('after_setup_theme', 'enable_classic_menu_interface');
add_action('wp_enqueue_scripts', 'load_more_gallery_scripts');
add_action('wp_ajax_load_more_gallery-images', 'load_more_gallery-images');  // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_load_more_gallery-images', 'load_more_gallery-images');  // Pour les visiteurs non connectés
add_filter('wp_nav_menu_objects', 'add_contact_link_class');
add_filter('the_content', 'ajouter_lazy_loading');