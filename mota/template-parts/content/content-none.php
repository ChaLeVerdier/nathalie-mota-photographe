<?php

/**
 * Template part pour afficher un message quand aucun contenu n'est trouvé
 *
 * @package mota
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Rien trouvé', 'mota'); ?></h1>
    </header>

    <div class="page-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __('Prêt à publier votre premier article ? <a href="%1$s">Commencez ici</a>.', 'mota'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );

        elseif (is_search()) :
        ?>

            <p><?php esc_html_e('Désolé, mais rien ne correspond à vos termes de recherche. Veuillez réessayer avec des mots-clés différents.', 'mota'); ?></p>
        <?php
            get_search_form();

        else :
        ?>

            <p><?php esc_html_e('Il semble que nous ne trouvions pas ce que vous cherchez. Peut-être qu\'une recherche pourrait vous aider.', 'mota'); ?></p>
        <?php
        endif; // Ajout de la balise de fermeture ici
        ?>
    </div>
</section>