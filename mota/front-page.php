

<?php
/**
 * Front Page Template - Page d'accueil
 * 
 * Ce fichier affiche le contenu de la page d'accueil de mon site.
 * Il inclut les sections principales, telles que le Hero, la galerie photo, etc.
 * Les templates partiels sont utilisés pour garder le code organisé.
 * 
 * @package Mota
 */

get_header(); // On charge l'en-tête de la page

?>

<main id="primary" class="site-main">

    <?php
    // Vérification de l'existence du template pour la section Hero (haut de page)
    $template_hero = locate_template('template-parts/hero-header.php'); 
    if ($template_hero) {
        // Si le template hero existe, on l'inclut
        get_template_part('template-parts/hero-header');
    } else {
        // Si le template hero n'est pas trouvé, afficher un message d'erreur
        echo '<p class="template-error">' . esc_html(__('Le template hero est indisponible.', 'mota')) . '</p>';
    }

    // Vérification de l'existence du template pour la section photo
    $template_section_photo = locate_template('template-parts/section-photo.php'); 
    if ($template_section_photo) {
        // Si le template pour la section photo existe, on l'inclut
        get_template_part('template-parts/section-photo');
    } else {
        // Si le template section-photo n'est pas trouvé, afficher un message d'erreur
        echo '<p class="template-error">' . esc_html(__('Le template photo est indisponible.', 'mota')) . '</p>';
    }
    ?>

</main>

<?php
get_sidebar(); // Charge la barre latérale si nécessaire
get_footer();  // Charge le pied de page
?>
