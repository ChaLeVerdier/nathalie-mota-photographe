<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php 
        // Affichage du titre de l'article. Le titre est un lien pointant vers la page de l'article complet.
        // La fonction esc_url permet de sécuriser l'URL avant de l'afficher.
        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
        ?>
    </header>

    <div class="entry-summary">
        <?php 
        // Affichage de l'extrait de l'article, qui est une version condensée du contenu.
        // C'est ce qui s'affichera dans les pages de blog ou les archives de manière générale.
        the_excerpt(); 
        ?>
    </div>
</article>
