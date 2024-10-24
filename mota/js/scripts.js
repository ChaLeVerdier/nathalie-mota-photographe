jQuery(document).ready(function($) {
  const modal = $('#modal-contact');
  const openModalButtons = $('.open-modal');
  const closeButton = modal.find('.close');
  const photoReferenceField = modal.find('input[name="photo-reference"]'); 
  const form = modal.find('.wpcf7-form'); // Récupération du formulaire Contact Form 7

  function openModal(photoId) {
      modal.addClass('show');
      // Remplir le champ "RÉF. PHOTO" avec la référence de la photo
      if (photoReferenceField.length) {
          photoReferenceField.val(photoId); // Ajout de l'ID de la photo au champ
      }
  }

  // Fonction pour fermer la modale
  function closeModal() {
    modal.removeClass('show'); // Cache la modale en retirant la classe 'show'

    // Réinitialise le formulaire et supprime les erreurs de validation
    if (form.length) {
        form[0].reset(); // Réinitialise le formulaire
        form.find('.wpcf7-not-valid-tip').remove(); // Supprime les messages d'erreur
        form.find('.wpcf7-validation-errors').remove(); // Supprime les erreurs générales
    }
}

  // Ouvrir la modal avec la bonne référence photo
  openModalButtons.on('click', function() {
      const photoId = $(this).data('photo-id'); // Récupérer l'ID de la photo
      openModal(photoId);
  });

  // Fermer la modal en cliquant sur la croix
  closeButton.on('click', closeModal);

  openModalButtons.on('click', function(e) {
    e.preventDefault();
    const photoId = $(this).data('photo-id'); // Suppose que tu passes un ID de photo via un attribut data
    openModal(photoId);
});

// Événement pour fermer la modale
closeButton.on('click', function() {
    closeModal();
});

// Fermer la modale en cliquant en dehors du contenu
$(window).on('click', function(event) {
    if ($(event.target).is(modal)) {
        closeModal();
    }
});

// Réinitialise le formulaire au chargement de la page
$(document).on('DOMContentLoaded', function() {
    closeModal(); // Ferme et réinitialise la modale au cas où elle serait ouverte après rafraîchissement
});

 // Ouvre la modale quand on clique sur le lien "Contact"
 $('.contact-link').on('click', function(e) {
  e.preventDefault();
  openModal(); // Ouvre la modale
});

});



// appelle nos photos :
// document.addEventListener('DOMContentLoaded', function() {
//     document.querySelector('#ajax_call').addEventListener('click', function() {
//       let formData = new FormData();
//       formData.append('action', 'request_photos');
   
   
//       fetch(cookinfamily_js.ajax_url, {
//         method: 'POST',
//         body: formData,
//       }).then(function(response) {
//         if (!response.ok) {
//           throw new Error('Network response error.');
//         }
   
   
//         return response.json();
//       }).then(function(data) {
//         data.posts.forEach(function(post) {
//           document.querySelector('#ajax_return').insertAdjacentHTML('beforeend', '<div class="col-12 mb-5">' + post.post_title + '</div>');
//         });
//       }).catch(function(error) {
//         console.error('There was a problem with the fetch operation: ', error);
//       });
//     });
//    });












// // ******************* OLD ****************

// // Attendre que le DOM soit complètement chargé
// // document.addEventListener('DOMContentLoaded', () => {
// //      const contactModal = document.querySelector('.contact-modal'); // Récupérer la modal de contact
// //      const openButton = document.getElementById('open-contact-modal'); // ID du bouton qui ouvre la modal
// //      const closeButton = document.querySelector('.close-button'); // Classe pour le bouton de fermeture
 
// //      // Vérifier si la modal et le bouton d'ouverture existent
// //      if (!contactModal) {
// //          console.warn('Aucune modal trouvée avec la classe "contact-modal".');
// //          return; // Arrêter l'exécution si aucune modal n'est trouvée
// //      }
 
// //      if (!openButton) {
// //          console.warn('Aucun bouton trouvé pour ouvrir la modal.');
// //          return; // Arrêter l'exécution si aucun bouton n'est trouvé
// //      }
 
// //      if (!closeButton) {
// //          console.warn('Aucun bouton trouvé pour fermer la modal.');
// //          return; // Arrêter l'exécution si aucun bouton de fermeture n'est trouvé
// //      }
 
// //      // Fonction pour ouvrir la modal
// //      const openModal = () => {
// //          contactModal.style.display = 'block'; // Afficher la modal
// //      };
 
// //      // Fonction pour fermer la modal
// //      const closeModal = () => {
// //          contactModal.style.display = 'none'; // Masquer la modal
// //      };
 
// //      // Ouvrir la modal
// //      openButton.addEventListener('click', openModal);
 
// //      // Fermer la modal
// //      closeButton.addEventListener('click', closeModal);
 
// //      // Fermer la modal si l'utilisateur clique en dehors
// //      window.addEventListener('click', (event) => {
// //          if (event.target === contactModal) {
// //              closeModal(); // Masquer la modal si on clique sur le fond
// //          }
// //      });
// //  });
 