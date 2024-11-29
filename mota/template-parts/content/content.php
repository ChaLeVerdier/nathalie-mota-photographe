<?php
/**
 * Template part pour l'affichage des posts (photo)
 *
 * @package Mota
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        // Vérifie si on affiche un article unique (page dédiée)
        if ( is_singular() ) :
            // Si c'est un article unique, afficher le titre dans une balise <h1>
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            // Sinon, afficher le titre sous forme de lien <h2> vers l'article complet
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;

        // Si le type de contenu est "post" (article de blog)
        if ( 'post' === get_post_type() ) :
            ?>
            <div class="entry-meta">
                <?php
                // Afficher la date de publication de l'article
                echo esc_html( get_the_date() );
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        // Si c'est une page d'article unique, afficher le contenu complet
        if ( is_singular() ) :
            the_content();
        else :
            // Sinon, afficher un extrait du contenu avec un lien pour lire l'article complet
            the_excerpt();
            ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more">
                <?php esc_html_e( 'Lire la suite', 'mota' ); ?>
            </a>
            <?php
        endif;
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
        // Récupérer et afficher la liste des catégories liées à l'article
        $categories_list = get_the_category_list( esc_html__( ', ', 'mota' ) );
        if ( $categories_list ) {
            printf(
                '<span class="cat-links">' . esc_html__( 'Publié dans %1$s', 'mota' ) . '</span>',
                $categories_list
            );
        }

        // Récupérer et afficher la liste des tags associés à l'article
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mota' ) );
        if ( $tags_list ) {
            printf(
                '<span class="tags-links">' . esc_html__( 'Tagué %1$s', 'mota' ) . '</span>',
                $tags_list
            );
        }
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
