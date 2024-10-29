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
</footer>

<?php get_template_part('template-parts/modal', 'contact'); ?>
<?php wp_footer(); ?>
</body>
</html>
