document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('load-more-btn').addEventListener('click', function () {
        // Création d'une requête AJAX
        let xhr = new XMLHttpRequest();
        xhr.open('POST', myAjax.ajaxurl, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Définir les actions pour la réponse de la requête
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Ajouter le contenu reçu au footer
                let newContent = document.createElement('div');
                newContent.classList.add('new-content');
                newContent.innerHTML = xhr.responseText;
                document.querySelector('footer').appendChild(newContent);
            } else {
                console.log('Erreur lors du chargement du contenu.');
            }
        };

        // Gérer les erreurs
        xhr.onerror = function () {
            console.log('Erreur de connexion.');
        };

        // Envoi de la requête avec les données
        xhr.send('action=load_more_content');
    });
});


jQuery(document).ready(function ($) {
    $('#load-more-btn').on('click', function () {
        $.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: { action: 'load_more_content' },
            success: function (response) {
                $('footer').append('<div class="new-content">' + response + '</div>');
            },
            error: function () {
                console.log('Erreur lors du chargement du contenu.');
            }
        });
    });
});




// Load more footer content


document.addEventListener('DOMContentLoaded', function () {
    console.log('Script My Ajax Script chargé avec succès !'); // Vérifie si le script est chargé

    const loadMoreButton = document.getElementById('load-more-btn');
    const footer = document.querySelector('footer');

    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function () {
            console.log('Bouton "load-more-btn" cliqué'); // Vérifie que le clic fonctionne

            // Création de la requête AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', myAjax.ajaxurl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Avant l'envoi de la requête
            console.log('Envoi de la requête AJAX...'); // Confirme que la requête est sur le point de partir

            // Gestion de la réponse
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Réponse reçue :', xhr.responseText); // Affiche la réponse reçue dans la console
                    const newContent = document.createElement('div');
                    newContent.classList.add('new-content');
                    newContent.innerHTML = xhr.responseText;
                    footer.appendChild(newContent); // Ajoute la réponse au pied de page
                } else {
                    console.log('Erreur lors du chargement du contenu.');
                    console.log('Status:', xhr.status); // Affiche le statut de l'erreur
                    console.log('Response:', xhr.statusText); // Affiche le message d'erreur
                }
            };

            // Gestion des erreurs de connexion
            xhr.onerror = function () {
                console.log('Erreur de connexion.');
            };

            // Données à envoyer
            const data = 'action=load_more_content';
            xhr.send(data);
        });
    } else {
        console.log('Bouton "load-more-btn" introuvable'); // Vérifie que le bouton existe
    }
});





// Image cliquée


document.addEventListener('DOMContentLoaded', function () {
    console.log('Script pour "ajax-image" chargé avec succès !'); // Vérifie si le script est chargé

    const ajaxImage = document.getElementById('ajax-image');
    const ajaxResponse = document.getElementById('ajax-response');

    if (ajaxImage) {
        ajaxImage.addEventListener('click', function () {
            console.log('Image cliquée'); // Vérifie que le clic fonctionne

            const xhr = new XMLHttpRequest();
            xhr.open('POST', myAjax.ajaxurl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Réponse reçue :', xhr.responseText);
                    ajaxResponse.innerHTML = xhr.responseText;
                } else {
                    ajaxResponse.innerHTML = 'Erreur lors de la requête.';
                }
            };

            xhr.onerror = function () {
                ajaxResponse.innerHTML = 'Erreur de connexion.';
            };

            const data = 'action=image_click_action&message=' + encodeURIComponent("Utilisateur a cliqué sur l'image");
            xhr.send(data);
        });
    } else {
        console.log('Image "ajax-image" introuvable'); // Message si l'image n'est pas trouvée
    }
});





