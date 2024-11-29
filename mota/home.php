 <?php
/**
 * Template pour la page d'accueil du blog
 * Si un modèle plus spécifique comme front-page.php n'est pas disponible, ce fichier est utilisé comme modèle de secours pour afficher la liste des posts sur la page d'accueil.
 *
 *
 * @package Mota
 */



get_header();
?>



<?php
get_header();
?>

<!-- Début de la section principale de la page d'accueil -->
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php
        // Vérification s'il y a des posts à afficher
        if ( have_posts() ) :
            
            // Affichage du titre de la page s'il s'agit de la page d'accueil mais pas de la première page
            if ( is_home() && ! is_front_page() ) :
                ?>
                <header>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
                <?php
            endif;
            
            // Démarrer la boucle WordPress qui parcourt les posts
            while ( have_posts() ) :
                the_post();
                
                get_template_part( 'template-parts/content/content', get_post_type() );

            endwhile;

            // Navigation des posts (précédent / suivant)
            the_posts_navigation();

        else :
            // Si aucun post n'est trouvé, afficher un message
            get_template_part( 'template-parts/content/content', 'none' );
        endif;
        ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php

get_footer();
?>
