<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <!-- Affichage du titre de l'article -->
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
  </header>

  <div class="entry-content">
    <!-- Contenu principal de l'article -->
    <?php
    // Affichage du contenu de l'article
    the_content();
    ?>
  </div>
</article>
