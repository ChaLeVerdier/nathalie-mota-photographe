<?php
/**
 * Le template pour afficher le pied de page
 *
 * Ce fichier affiche le pied de page du site, incluant la navigation et les modals.
 *
 * @package Mota
 */
?>

<!-- Colophon : convention pour désigner la section du pied de page -->
<footer id="colophon" class="site-footer">
    <nav>
        <?php
        // Affiche le menu du pied de page
        wp_nav_menu(
            array(
                'theme_location' => 'footer-menu', // Emplacement du menu de pied de page
                'container_class' => 'footer-menu-container',
                'menu_class'      => 'footer-menu', // Classe CSS pour le menu
            )
        );
        ?>
    </nav>

    <?php
    // Vérifie si le template contact-modal.php existe et l'inclut
    $template_part_modale = locate_template('template-parts/modal-contact.php');
    if ($template_part_modale) {
        get_template_part('template-parts/modal-contact'); // Ajoute la modale de contact
    } else {
        echo '<p>Le template contact modal est indisponible.</p>'; // Message d'erreur si template non trouvé
    }
    ?>

    <?php
    // Vérifie si le template lightbox-modal.php existe et l'inclut
    $template_part_modale = locate_template('template-parts/lightbox-modal.php');
    if ($template_part_modale) {
        get_template_part('template-parts/lightbox-modal'); // Ajoute la lightbox
    } else {
        echo '<p>Le template de la lightbox est indisponible.</p>'; // Message d'erreur si template non trouvé
    }
    ?>

</footer>

<?php wp_footer(); 
?>
</body>
</html>
