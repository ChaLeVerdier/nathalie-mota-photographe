// On récupère toutes les catégories associées aux photos
                    $categories = get_terms(array(
                        'taxonomy' => 'photo-categorie', // Taxonomie pour la catégorie de photo
                        'hide_empty' => true, // Ne pas afficher les catégories vides
                    ));

                    // On récupère tous les formats associés aux photos
                    $formats = get_terms(array(
                        'taxonomy' => 'photo-format', // Taxonomie pour le format de photo
                        'hide_empty' => true, // Ne pas afficher les formats vides
                    ));