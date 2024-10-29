<?php
/**
 * Template part for displaying single photo content
 *
 * @package Mota
 */


 
// Récupération des valeurs ACF
$reference = get_field('reference');
$type = get_field('type');

// Récupération de l'année à partir de la date de publication
$annee = get_the_date('Y');

// Récupération des termes de taxonomie
$categories = get_the_terms(get_the_ID(), 'categorie');
$formats = get_the_terms(get_the_ID(), 'format');
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header>

    <div class="entry-content">
        <?php
        // Affichage du contenu
        the_content();

        // Affichage des champs ACF et de l'année
        if ($reference) :
            echo '<div class="photo-reference"><strong>Référence : </strong>' . esc_html($reference) . '</div>';
        endif;

        if ($type) :
            echo '<div class="photo-type"><strong>Type : </strong>' . esc_html($type) . '</div>';
        endif;

        echo '<div class="photo-annee"><strong>Année : </strong>' . esc_html($annee) . '</div>';


        // Affichage des termes de taxonomie
        if ($categories && !is_wp_error($categories)) :
            echo '<div class="photo-categorie"><strong>Catégorie : </strong>';
            $category_names = wp_list_pluck($categories, 'name');
            echo esc_html(implode(', ', $category_names));
            echo '</div>';
        endif;

        if ($formats && !is_wp_error($formats)) :
            echo '<div class="photo-format"><strong>Format : </strong>';
            $format_names = wp_list_pluck($formats, 'name');
            echo esc_html(implode(', ', $format_names));
            echo '</div>';
        endif;
        ?>
    </div>
</article>

