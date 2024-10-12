<?php

// Gère la version du thème, bonne pratique pour les mises à jour
if ( ! defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '1.0.0' );
}

// Thème multilingue
load_theme_textdomain('mota', get_template_directory() . '/languages');

// Chargement des styles
function mota_enqueue_styles() {
    wp_enqueue_style('mota-main-style', get_template_directory_uri() . '/assets/css/main.css');
}

// Chargement des scripts
function mota_enqueue_scripts() {
    wp_enqueue_script('mota-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
}

// Enregistrement des menus
function mota_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mota'),
    ));
}

// Configuration du thème
function mota_setup() {
    // Charge le domaine de texte pour la traduction
    load_theme_textdomain('mota', get_template_directory() . '/languages');

    // Support des flux RSS
    add_theme_support('automatic-feed-links');

    // Support pour le titre du document
    add_theme_support('title-tag');

    // Support des images mises en avant
    add_theme_support('post-thumbnails');

    // Support HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}

// Hooks d'action
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');
add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');
add_action('init', 'mota_register_menus');
add_action('after_setup_theme', 'mota_setup');  // Hook d'initialisation
