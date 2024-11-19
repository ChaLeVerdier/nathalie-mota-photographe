<?php
/**
 * Le template pour afficher le pied de page
 *
 * @package Mota
 */
?>

<!-- Colophon : convention pour désigner la section du pied de page  -->
<footer id="colophon" class="site-footer">
    <nav>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-menu',
                'container_class' => 'footer-menu-container',
                'menu_class' => 'footer-menu',
            )
        );
        ?>
    </nav>

    <?php
    // Ajoute template-part contact-modal.php
    $template_part_modale = locate_template('template-parts/modal-contact.php');
    if ($template_part_modale) {
        get_template_part('template-parts/modal-contact');
    } else {
        // Code alternatif si le template part n'existe pas
        echo '<p>Le template contact modal est indisponible.</p>';
    }
    ?>



<!-- Modale de lightbox -->
<div id="lightbox-modal" class="lightbox-modal">
    <span class="close-lightbox">&times;</span>
    <img id="lightbox-image" src="" alt="Image en plein écran">
</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
