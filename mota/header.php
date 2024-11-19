<?php

/**
 * En-tête de notre thème
 *
 * Ce modèle affiche toute la section <head> et tout jusqu'à <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mota
 */
?>

<?php //ob_start(); 
?>

<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Passer au contenu', 'mota'); ?></a> <!-- Lien pour l'accessibilité -->

    <header id="masthead">
      <div class="header-container">
        <div class="logo">
          <a href="<?php echo home_url(); ?>"> <!-- Lien vers la page d'accueil -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Logo du site">
        </div>

        <!-- header.php -->
        <nav class="main-navigation">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'main-menu', // Emplacement du menu enregistré
            'container_class'      => 'main-menu-container',
            'menu_class'     => 'main-menu', // Classe CSS pour styliser le menu
          ));
          ?>
        </nav>


        <!-- Icône du menu hamburger pour le mobile -->
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
              'theme_location' => 'main-menu',
              'container_class' => 'mobile-menu-container',
              'menu_class' => 'mobile-menu-list',
            )
          );
          ?>
        </div>


      </div> <!-- header-container -->

      <?php get_template_part('template-parts/modal', 'contact'); ?>
    </header><!-- #masthead -->