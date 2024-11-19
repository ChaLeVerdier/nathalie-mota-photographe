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



        // ********** Ajout scripts et styles*********** //


function mota_enqueue_assets() {
    // Enregistrer et charger le style principal
    $css_file = get_template_directory() . '/assets/css/main.css';

    if (file_exists($css_file)) {
        wp_enqueue_style(
            'mota-main-style',
            get_template_directory_uri() . '/assets/css/main.css',
            array(),
            filemtime($css_file)
        );
    }

// Enregistrer et charger les scripts
$js_files = array(
    'mota-main' => '/js/scripts.js',
    'mota-lightbox' => '/js/lightbox.js',
    'mota-burger' => '/js/menu-hamburger.js',
    'mota-ajax-script' => '/js/my-ajax-script.js'
);

foreach ($js_files as $handle => $file) {
    $js_file = get_template_directory() . $file;

    if (file_exists($js_file)) {
        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . $file,
            array(),
            filemtime($js_file),
            true
        );


        //Localiser l'URL AJAX uniquement pour my-ajax-script.js
        if ($handle === 'mota-ajax-script') {
            wp_localize_script($handle, 'myAjax', array(
                'ajaxurl' => admin_url('admin-ajax.php')
            ));
        }


        error_log("Script enqueued: " . $handle);
    } else {
        error_log("Script file not found: " . $js_file);
    }
}
}
add_action('wp_enqueue_scripts', 'mota_enqueue_assets');



// ****************************************************************** //
// ******* Hero : Personnalisation du titre H1 via Backoffice ******* //
// ****************************************************************** //

function mota_customize_register($wp_customize) {
    // Section pour le Hero
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Section Hero', 'mota'),
        'priority' => 30,
    ));

    // Paramètre pour le texte du H1
    $wp_customize->add_setting('hero_title_text', array(
        'default'           => __('Photographe Event', 'mota'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
 // Contrôle pour le texte du H1
 $wp_customize->add_control('hero_title_text_control', array(
    'label'    => __('Texte du Titre H1', 'mota'),
    'section'  => 'hero_section',
    'settings' => 'hero_title_text',
    'type'     => 'text',
));
}

add_action('customize_register', 'mota_customize_register');


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

add_action('init', 'mota_register_menus');


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

// Ajouter une taille personnalisée pour les miniatures de la galerie
function custom_theme_setup() {
    add_image_size('gallery-thumbnail', 564, 495, true); // 564x495px, avec recadrage forcé
}
add_action('after_setup_theme', 'custom_theme_setup');


// Fonction pour ajouter l'attribut loading="lazy" aux images
function ajouter_lazy_loading($content) {
    return str_replace('<img', '<img loading="lazy"', $content);
}

add_filter('the_content', 'ajouter_lazy_loading');


// Ajouter la prise en charge des formats de publication AVIF dans WordPress
function add_avif_support($mime_types) {
    $mime_types['avif'] = 'image/avif';
    return $mime_types;
}

add_filter('mime_types', 'add_avif_support');


// *********************************************************** //
// ********* Ajoute la modale au menu Contact + la reference perso********* //
// *********************************************************** //

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

add_filter('wp_nav_menu_objects', 'add_contact_link_class');



/*** Pagination infinie ***/


// Ajouter une fonction pour charger plus de photos
function enqueue_load_more_script() {
    wp_enqueue_script('load-more', get_template_directory_uri() . '/js/load-more.js', array(), null, true);

    // Obtenez le nombre total de pages pour la pagination
    $total_photos_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
    ));
    $max_pages = $total_photos_query->max_num_pages;
    wp_reset_postdata();

    // Transmet les variables PHP vers JavaScript, y compris le nonce
    wp_localize_script('load-more', 'load_more_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'max_pages' => $max_pages,
        'nonce' => wp_create_nonce('load_more_photos_nonce') // Génère et ajoute le nonce
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');




// ***************************************************** //
// *********** Load-more front-page-gallery *************** //
// ***************************************************** //

// Fonction PHP pour Gérer la Requête AJAX
function load_more_photos() {


    // Vérifie le nonce pour sécuriser la requête
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_photos_nonce')) {
        wp_send_json_error('Nonce invalide'); // Envoie une erreur JSON si le nonce est invalide
        die();
    }

    // Récupère le numéro de page à partir de la requête AJAX
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Arguments pour la requête des photos
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

    // Exécutez la requête
    $photos = new WP_Query($args);

    // Récupérer les IDs des posts pour les passer au template part
    $post_ids = array();
    if ($photos->have_posts()) :
        while ($photos->have_posts()) : $photos->the_post();
            $post_ids[] = get_the_ID();
        endwhile;
    endif;

    wp_reset_postdata();

    // Utiliser le template part 'photo_block' pour afficher les résultats
    if (!empty($post_ids)) {
        // Passer les IDs au template part pour afficher les miniatures
        get_template_part('template-parts/photo-block', null, array('post_ids' => $post_ids));
    } else {
        echo ''; // Si aucune photo supplémentaire, retourne une chaîne vide
    }

    wp_die(); // Fin de la requête AJAX
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');



/*** FILTRES ***/

function enqueue_filter_scripts() {
    // Enqueuez votre fichier JavaScript
    wp_enqueue_script('filter-scripts', get_template_directory_uri() . '/js/filters.js', array('jquery'), null, true);

    // Passez l'URL AJAX à JavaScript sous le nom "ajaxurl"
    wp_localize_script('filter-scripts', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_filter_scripts');

// Ajouter une fonction pour filtrer les photos
function filter_photos() {
    // Récupérer les filtres depuis la requête AJAX
    $category = sanitize_text_field($_POST['category']);
    $format = sanitize_text_field($_POST['format']);
    $order = sanitize_text_field($_POST['order']) ?: 'DESC';

    // Configuration des arguments de la requête WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'order' => $order,
    );

    // Construire la tax_query si des filtres sont sélectionnés
    $tax_query = array('relation' => 'AND');

    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'photo-categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'photo-format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    // Exécuter la requête pour récupérer les photos filtrées
    $photos = new WP_Query($args);

    // Récupérer les IDs des posts filtrés
    $post_ids = array();
    if ($photos->have_posts()) :
        while ($photos->have_posts()) : $photos->the_post();
            $post_ids[] = get_the_ID();
        endwhile;
    endif;

    wp_reset_postdata();

    // Utiliser le template part 'photo_block' pour afficher les résultats
    if (!empty($post_ids)) {
        get_template_part('template-parts/photo_block', null, array('post_ids' => $post_ids));
    } else {
        echo '<p>' . esc_html__('Aucune photo trouvée', 'votretheme') . '</p>';
    }

    // Fin de la requête AJAX
    die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');



// Ajouter une fonction pour gérer les clics sur les images

function handle_image_click() {
    // Exemple de réponse renvoyée par le serveur
    echo "Merci d'avoir cliqué sur l'image ! Voici plus d'informations.";
    wp_die(); // Fin de la requête AJAX
}
add_action('wp_ajax_image_click_action', 'handle_image_click'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_image_click_action', 'handle_image_click'); // Pour les utilisateurs non connectés



//lightbox

function mota_enqueue_lightbox_script() {
    wp_enqueue_script(
        'mota-lightbox',
        get_template_directory_uri() . '/js/lightbox.js',
        array('jquery'),
        filemtime(get_template_directory() . '/js/lightbox.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'mota_enqueue_lightbox_script');



// ******************************************* //
// ************* Hooks d'action ************** //
// ******************************************* //





