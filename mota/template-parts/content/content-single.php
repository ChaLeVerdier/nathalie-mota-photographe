<?php
/**
 * Template part pour afficher le contenu d'un article individuel
 *
 * @package Mota
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!-- Début de l'article, avec un ID unique basé sur l'identifiant du post et des classes dynamiques ajoutées via WordPress -->

  <header class="entry-header">
    <?php 
    // Affiche le titre de l'article, entouré d'une balise <h1>
    the_title('<h1 class="entry-title">', '</h1>'); 
    ?>
  </header>
  <!-- En-tête de l'article contenant uniquement le titre -->

  <div class="entry-content">
    <?php
    // Affiche le contenu complet de l'article (texte, images, etc.)
    the_content(); 
    ?>
  </div>
  <!-- Section principale de l'article contenant le contenu complet -->
</article>
<!-- Fin de l'article -->

