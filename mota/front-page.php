<?php

/**
 * Hero de l'en-tête 
 *
 * @package Mota
 */

get_header(); ?>

<main id="primary" class="site-main">
  
            
                <?php
                //ajoute template-parts hero.php
                $template_part = locate_template('template-parts/hero-header.php');
                if ($template_part) {
                    get_template_part('template-parts/hero-header');
                } else {
                    // Code alternatif si le template part n'existe pas
                    echo '<p>Le template hero est indisponible.</p>';
                }
                ?>
      
      <?php
    //ajoute template-parts hero.php
    $template_part = locate_template('template-parts/section-photo.php');
    if ($template_part) {
        get_template_part('template-parts/section-photo');
    } else {
        // Code alternatif si le template part n'existe pas
        echo '<p>Le template filtre est indisponible.</p>';
    }
    ?>





</main>

<?php
get_sidebar();
get_footer();
