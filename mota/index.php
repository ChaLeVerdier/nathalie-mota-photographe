<?php
/**
 * Le template principal
 * 
 * Ce fichier est utilisé pour afficher la page d'accueil et toutes les archives dans WP.
 * Il sert de modèle pour l'affichage des articles et est souvent personnalisé.
 *
 * @package Mota
 */

get_header();
?>

    <!-- Cette section sert à afficher le contenu principal de la page -->
    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php
        // Vérifie s'il y a des articles à afficher
        if ( have_posts() ) :

            // Si on est sur la page d'accueil mais pas sur la page d'accueil statique
            if ( is_home() && ! is_front_page() ) :
                ?>
                <header>
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
                <?php
            endif;

            // Démarrer la boucle pour afficher chaque post
            while ( have_posts() ) : // Vérifie s'il y a des posts disponibles pour l'affichage.
                the_post(); // Charge les informations du post actuel dans la boucle WordPress (ex: titre, contenu, date, etc.)

               // charger un modèle de contenu spécifique en fonction du type de post.
                 
                get_template_part( 'template-parts/content/content', get_post_type() ); // récupère le type de post actuel 

            endwhile; // Fin de la boucle. Si un autre post existe, le processus recommence avec un autre post.

            // Ajouter une navigation pour les pages d'archives ou multiples articles
            the_posts_navigation();

        else :

            // Si aucun article n'est trouvé, afficher un template de "aucun contenu"
            get_template_part( 'template-parts/content/content', 'none' );

        endif;
        ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
//get_sidebar();  // Le sidebar peut être inclus ici si nécessaire
get_footer();


