<?php
/**
 * Fonctions et définitions du thème
 *
 * @package mota
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// On vérifie que le fichier est bien appelé depuis WordPress et non directement
if (!defined('ABSPATH')) {
    exit; // Sortie si on y accéde directement
}

// Gestion de la version du thème, pour assurer la mise à jour des styles
if ( ! defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '1.0.0' );
}

// Chargement du texte pour la traduction du thème (multilingue)
load_theme_textdomain('mota', get_template_directory() . '/languages');

// Restreindre l'accès au back-office aux administrateurs uniquement
function restrict_access_to_admin_only() {
    if ( !current_user_can( 'administrator' ) && is_admin() ) {
        wp_redirect( home_url() );  // Redirige les utilisateurs non-administrateurs vers la page d'accueil
        exit;
    }
}
// Applique la restriction dès qu'on essaie d'accéder à l'administration
add_action( 'template_redirect', 'restrict_access_to_admin_only' );


// ********** Ajout des scripts et styles *********** //

function mota_enqueue_assets() {
    // Enregistrer et charger le style principal du thème
    $css_file = get_template_directory() . '/assets/css/main.css';

    // Si le fichier CSS existe, on l'enregistre
    if (file_exists($css_file)) {
        wp_enqueue_style(
            'mota-main-style',
            get_template_directory_uri() . '/assets/css/main.css',
            array(),
            filemtime($css_file)
        );
    }

    // Liste des fichiers JavaScript à ajouter au site
    $js_files = array(
        'mota-main' => '/js/scripts.js',
        'mota-lightbox' => '/js/lightbox.js',
        'mota-burger' => '/js/menu-hamburger.js',
        'mota-select' => '/js/custom-select.js',

    );

    // Enregistre chaque fichier JS s'il existe
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

            // Localiser l'URL AJAX uniquement pour my-ajax-script.js
            if ($handle === 'mota-ajax-script') {
                wp_localize_script($handle, 'myAjax', array(
                    'ajaxurl' => admin_url('admin-ajax.php')
                ));
            }

            error_log("Script enqueued: " . $handle); // Journalise les scripts ajoutés
        } else {
            error_log("Script file not found: " . $js_file); // Si le fichier n'est pas trouvé
        }
    }
}
add_action('wp_enqueue_scripts', 'mota_enqueue_assets');

// ******************************************************************* //
// ******* Chargement de scripts personnalisés Red (filtres JS) ********** //
// ******************************************************************* //

// function mota_enqueue_scripts() {
//     // Charger le fichier JavaScript pour les filtres personnalisés
//     wp_enqueue_script('custom-filters', get_template_directory_uri() . '/js/custom-filters.js', array('jquery'), null, true);
// }
// add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');

// ****************************************************************** //
// ******* Personnalisation du titre H1 dans la section Hero ******* //
// ****************************************************************** //

function mota_customize_register($wp_customize) {
    // Section pour personnaliser la section Hero
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Section Hero', 'mota'),
        'priority' => 30,
    ));

    // Paramètre pour personnaliser le texte du H1
    $wp_customize->add_setting('hero_title_text', array(
        'default'           => __('Photographe Event', 'mota'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Contrôle pour le texte du H1 dans le customizer
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
// ******************************************* /

function mota_register_menus() {
    // Enregistre les menus du thème (header, footer, réseaux sociaux)
    register_nav_menus(
        array(
            'main-menu' => esc_html__('Menu Principal', 'mota'), // Menu principal du header
            'footer-menu' => esc_html__('Menu Pied de page', 'mota'), // Menu du footer
            'social-menu' => esc_html__('Menu Réseaux sociaux', 'mota'), // Menu des réseaux sociaux
        )
    );
}
add_action('init', 'mota_register_menus');

// ******************************************** //
// *********** Gestion des images ************* //
// ******************************************** //


add_theme_support('post_thumbnails'); // Active les images mises en avant

// Prise en charge de l'interface classique des menus
function enable_classic_menu_interface() {
    add_theme_support('menus');
}

// Ajoute une taille d'image personnalisée pour les miniatures
add_image_size('featured-thumbnail', 350, 233, true); // Taille de l'image en vignette avec recadrage

// Ajoute une taille pour les images dans la galerie
function custom_theme_setup() {
    add_image_size('gallery-thumbnail', 564, 495, true); // 564x495px avec recadrage
}
add_action('after_setup_theme', 'custom_theme_setup');

// Ajoute l'attribut loading="lazy" pour un chargement plus rapide des images
function ajouter_lazy_loading($content) {
    return str_replace('<img', '<img loading="lazy"', $content); // Ajoute lazy loading
}
add_filter('the_content', 'ajouter_lazy_loading');

// *********************************************************** //
// ************** Ajout de support pour AVIF ***************** //
// *********************************************************** //

function add_avif_support($mime_types) {
    $mime_types['avif'] = 'image/avif'; // Support pour le format d'image AVIF
    return $mime_types;
}
add_filter('mime_types', 'add_avif_support');

// *********************************************************** //
// ********* Ajoute la modale au menu Contact *************** //
// *********************************************************** //

function add_contact_link_class($items) {
    foreach ($items as $item) {
        // Ajouter une classe au lien "Contact"
        if ($item->title == 'Contact') {
            $item->classes[] = 'contact-link';
            
            // Ajouter une référence photo pour les pages photo
            if (is_singular('photo')) {
                $reference = get_field('reference');
                $item->url .= '" data-photo-ref="' . esc_attr($reference);
            }
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'add_contact_link_class');

// *********************************************************** //
// *********** Pagination infinie (Load More) *************** //
// *********************************************************** //

function enqueue_load_more_script() {
    wp_enqueue_script('load-more', get_template_directory_uri() . '/js/load-more.js', array(), null, true);

    // Récupère le nombre total de pages pour la pagination
    $total_photos_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
    ));
    $max_pages = $total_photos_query->max_num_pages;
    wp_reset_postdata();

    // Transmet des variables PHP vers JavaScript, comme le nonce pour sécurité
    wp_localize_script('load-more', 'load_more_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'max_pages' => $max_pages,
        'nonce' => wp_create_nonce('load_more_photos_nonce') // Génère un nonce pour sécuriser la requête
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');

// *********************************************************** //
// *********** Fonction pour gérer la requête AJAX *********** //
// *********************************************************** //

function load_more_photos() {
    // Vérifie le nonce pour sécuriser la requête
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_photos_nonce')) {
        wp_send_json_error(['message' => 'Nonce invalide']);
        wp_die();
    }

    // Récupère la page demandée
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    if ($paged < 1) {
        wp_send_json_error(['message' => 'Numéro de page invalide']);
        wp_die();
    }

    // Arguments pour la requête WP_Query
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8, 
        'paged'          => $paged, 
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

  // Exécute la requête pour charger les photos avec WP_Query
    $photos = new WP_Query($args);

    if ($photos->have_posts()) {
        ob_start(); // Capture le HTML généré par le template part

        // Prépare les IDs des posts pour le template
        $post_ids = wp_list_pluck($photos->posts, 'ID'); // Récupère les IDs des posts
        get_template_part('template-parts/photo-block', null, ['post_ids' => $post_ids]);

        // Récupère le contenu HTML généré
        $html = ob_get_clean();

        wp_send_json_success([
            'html'       => $html,
            'max_pages'  => $photos->max_num_pages, // Renvoie le nombre total de pages
        ]);
    } else {
        wp_send_json_error(['message' => 'Aucune photo trouvée']);
    }

    wp_die(); // Termine la requête AJAX
}

// Ajoute les hooks pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// *********************************************************** //
// *********** Filtrer les photos ************** //
// *********************************************************** //

// Enqueue les scripts nécessaires pour le filtrage via AJAX
function enqueue_filter_scripts() {
    wp_enqueue_script('filter-scripts', get_template_directory_uri() . '/js/filters.js', array('jquery'), null, true);
    wp_localize_script('filter-scripts', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_filter_scripts');

// Fonction pour filtrer les photos selon plusieurs critères
function filter_photos() {
    // Récupérer les filtres depuis la requête AJAX et les assainir
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) && in_array($_POST['order'], ['ASC', 'DESC']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1; // Gestion de la pagination

    // Vérification de la validité des filtres
    if (empty($category) && empty($format)) {
        wp_send_json_error(array('message' => 'Aucun filtre spécifié.'));
        wp_die();
    }

    // Arguments de la requête WP_Query pour récupérer les photos
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8, // Nombre de photos par page
        'paged' => $paged,     // Pagination
        'orderby' => 'date',   // Tri par date
        'order' => $order,     // Ordre de tri (ASC ou DESC)
    );

    // Création de la tax_query si des filtres sont spécifiés
    $tax_query = array();

    // Filtrage par catégorie si la catégorie est spécifiée
    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'photo-categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    // Filtrage par format si le format est spécifié
    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'photo-format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    // Si des filtres sont appliqués, ajouter la tax_query aux arguments
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // Exécution de la requête WP_Query
    $photos = new WP_Query($args);

    // Si des photos sont trouvées
    if ($photos->have_posts()) {
        ob_start(); // Capture la sortie HTML
        $post_ids = wp_list_pluck($photos->posts, 'ID'); // Récupérer les IDs des posts
        get_template_part('template-parts/photo-block', null, array('post_ids' => $post_ids)); // Charger le template de photo
        $html = ob_get_clean(); // Récupérer le HTML généré

        // Retourner le HTML et le nombre maximum de pages pour la pagination
        wp_send_json_success(array(
            'html' => $html,
            'max_pages' => $photos->max_num_pages,
        ));
    } else {
        // Retourner une erreur si aucune photo n'est trouvée
        wp_send_json_error(array(
            'message' => esc_html__('Aucune photo trouvée.', 'Mota'),
        ));
    }

    wp_die(); // Fin propre de la requête AJAX
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

// Fonction pour gérer les clics sur les images (exemple de retour)
function handle_image_click() {
    echo "Merci d'avoir cliqué sur l'image ! Voici plus d'informations."; // Message à afficher
    wp_die(); // Fin de la requête AJAX
}
add_action('wp_ajax_image_click_action', 'handle_image_click'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_image_click_action', 'handle_image_click'); // Pour les utilisateurs non connectés

// Enqueue le script pour le lightbox (affichage des images en grand format)
function mota_enqueue_lightbox_script() {
    wp_enqueue_script(
        'mota-lightbox',
        get_template_directory_uri() . '/js/lightbox.js',
        array('jquery'),
        filemtime(get_template_directory() . '/js/lightbox.js'), // Utilisation du timestamp pour la mise en cache
        true
    );
}
add_action('wp_enqueue_scripts', 'mota_enqueue_lightbox_script');




// ********************************************** //
// **** Selecte2 pour styliser mes filtres ****** //
// ********************************************** //

// function enqueue_select2_assets() {
//     // CSS de Select2
//     wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
//     // JS de Select2
//     wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), null, true);
// }
// add_action('wp_enqueue_scripts', 'enqueue_select2_assets');


// function enqueue_select2_init() {
//     wp_enqueue_script('select2-init', get_template_directory_uri() . '/js/select2-init.js', array('jquery', 'select2-js'), null, true);
// }
// add_action('wp_enqueue_scripts', 'enqueue_select2_init');
