<?php //ob_start(); 
?>

<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
     <meta charset="<?php bloginfo('charset'); ?>">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header>
    <div class="header-container">
        <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Logo du site">
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#" id="open-contact-modal">Contact</a></li>
                <?php get_template_part('template-parts/modal', 'contact'); ?>
            </ul>
        </nav>
    </div>
    <div class="hero">
        <img src="<?php echo get_theme_mod('hero_image'); ?>" alt="Image Hero" class="hero-image hero-background">
        <div class="hero-title">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero_titre.png" alt="Titre du site">
        </div>
    </div>
</header>