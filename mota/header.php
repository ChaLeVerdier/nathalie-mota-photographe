<?php

/**
 * En-tête du thème
 *
 * Ce modèle gère l'affichage de la section <head> et de la section d'ouverture du corps de la page, y compris l'insertion du logo, du menu de navigation principal, du menu mobile et d'autres éléments d'en-tête.
 * Il inclut également les hooks nécessaires pour les scripts et les styles du thème via wp_head().
 *
 * Ce fichier est inclus dans toutes les pages du site, puisqu'il constitue la structure de l'en-tête du site.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mota
 */
?>


<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <!-- Hook WordPress pour inclure les styles et scripts -->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <div id="page" class="site">
    <!-- Lien de navigation rapide pour l'accessibilité -->
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Passer au contenu', 'mota'); ?></a>



    <header id="masthead">
      <div class="header-container">

        <!-- Section du logo, lien vers la page d'accueil -->
        <div class="logo">
          <a href="<?php echo home_url(); ?>"> <!-- Lien vers la page d'accueil -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Logo du site">
        </div>

        <!-- Menu principal du site -->
        <nav class="main-navigation">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'main-menu', // Emplacement du menu enregistré
            'container_class'      => 'main-menu-container',
            'menu_class'     => 'main-menu', // Classe CSS pour styliser le menu
          ));
          ?>
        </nav>

        <!-- Icône du menu hamburger pour la version mobile -->
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <!-- Menu mobile en overlay -->
        <div class="mobile-menu">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'main-menu', // Réutilisation du même menu pour le mobile
              'container_class' => 'mobile-menu-container',
              'menu_class' => 'mobile-menu-list',
            )
          );
          ?>
        </div>


      </div> <!-- header-container -->

    </header><!-- #masthead -->