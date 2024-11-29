<?php

/**
 * Template part pour afficher un message quand aucun contenu n'est trouvé
 *
 * @package mota
 */
?>

<div class="container">
    <div class="container-inner">

        <section class="no-results not-found">
            <header class="page-header">
                <!-- Titre de la section : message lorsque rien n'est trouvé -->
                <h1 class="page-title"><?php esc_html_e('Rien trouvé', 'mota'); ?></h1>
            </header>

            <div class="page-content">
                <?php
                // Si on est sur la page d'accueil et que l'utilisateur peut publier, afficher un message pour commencer un nouvel article
                if (is_home() && current_user_can('publish_posts')) :
                    printf(
                        '<p>' . wp_kses(
                            /* translators: 1: lien vers la page de publication dans l'admin WP */
                            __('Prêt à publier votre premier article ? <a href="%1$s">Commencez ici</a>.', 'mota'),
                            array(
                                'a' => array(
                                    'href' => array(),
                                ),
                            )
                        ) . '</p>',
                        esc_url(admin_url('post-new.php'))
                    );

                // Si on est sur une page de recherche et qu'aucun résultat n'est trouvé, afficher un message spécifique
                elseif (is_search()) :
                ?>

                    <p><?php esc_html_e('Désolé, mais rien ne correspond à vos termes de recherche. Veuillez réessayer avec des mots-clés différents.', 'mota'); ?></p>
                <?php
                    // Afficher le formulaire de recherche pour que l'utilisateur puisse refaire une recherche
                    get_search_form();

                // Si aucune des conditions précédentes n'est remplie, afficher un message générique
                else :
                ?>

                    <p><?php esc_html_e('Il semble que nous ne trouvions pas ce que vous cherchez. Peut-être qu\'une recherche pourrait vous aider.', 'mota'); ?></p>
                <?php
                endif; // Ajout de la balise de fermeture ici
                ?>
            </div>
        </section>

    </div>
</div>
