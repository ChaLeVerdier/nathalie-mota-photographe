
<?php
$query = new WP_Query([
        'post_type' => 'photos',
        'posts_per_page' => 1 // Correction de 'post_per_page' en 'posts_per_page'
    ]);

    if ($query->have_posts()) {
        $photos = [];
        while ($query->have_posts()) {
            $query->the_post();
            $photos[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_the_post_thumbnail_url(get_the_ID(), 'full'), // Récupère l'URL de l'image à la une
            ];
        }
        wp_send_json($photos); // Envoie les données des photos au format JSON
    } else {
        wp_send_json(false);
    }

    wp_die(); // Terminer l'exécution de la fonction