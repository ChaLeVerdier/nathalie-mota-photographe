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


// Chargement des styles
function mota_enqueue_styles() {
    wp_enqueue_style('mota-main-style', get_template_directory_uri() . '/assets/css/main.css');
}

// Chargement des scripts
function mota_enqueue_scripts() {
    wp_enqueue_script('mota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('load-more-photos', get_stylesheet_directory_uri() . '/js/load-more.js', array('jquery'), null, true);
}

// Enregistrement des menus
function mota_register_menus() {
    register_nav_menus(
        array(
            'main-menu' => esc_html__('Menu Principal', 'mota'), // Menu header
            'footer-menu' => esc_html__('Menu Pied de page', 'mota'), // Menu footer
            'social-menu' => esc_html__('Menu Réseaux sociaux', 'mota'), // Menu réseaux sociaux (blog)
        )
    );
}

// Ajouter la prise en charge des images mises en avant
add_theme_support('post_thumbnails');

// Ajouter la prise en charge de l'interface de menu classique
function enable_classic_menu_interface() {
    add_theme_support('menus');
}

// Ajouter la prise en charge des images de taille personnalisée
add_image_size('featured-thumbnail', 350, 233, true);

function add_contact_link_class($items) {
    foreach ($items as $item) {
        if ($item->title == 'Contact') { // Titre de l'élément du menu
            $item->classes[] = 'contact-link'; // Ajoute la classe 'contact-link'
        }
    }
    return $items;
}



// Hooks d'action
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');
add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');
add_action('init', 'mota_register_menus');
add_action('after_setup_theme', 'mota_register_menus');
add_action('after_setup_theme', 'enable_classic_menu_interface');
// add_action('wp_ajax_request_photos', 'mota_request_photos');
// add_action('wp_ajax_nopriv_request_photos', 'mota_request_photos');
add_filter('wp_nav_menu_objects', 'add_contact_link_class');