jQuery(document).ready(function ($) {
  const modal = $("#modal-contact");
  const openModalButtons = $(".open-modal");
  const closeButton = modal.find(".close");
  const photoReferenceField = modal.find('input[name="photo-reference"]');
  const form = modal.find(".wpcf7-form"); // Récupération du formulaire Contact Form 7
  const $window = $(window);
  const $document = $(document);

  function openModal(photoId) {
    modal.addClass("show");
    // Remplir le champ "RÉF. PHOTO" avec la référence de la photo
    if (photoReferenceField.length) {
      photoReferenceField.val(photoId); // Ajout de l'ID de la photo au champ
    } else {
      console.warn("Champ de référence photo non trouvé");
    }
  }

  // Fonction pour fermer la modale
  function closeModal() {
    modal.removeClass("show"); // Cache la modale en retirant la classe 'show'

    // Réinitialise le formulaire et supprime les erreurs de validation
    if (form.length) {
      form[0].reset(); // Réinitialise le formulaire
      form.find(".wpcf7-not-valid-tip").remove(); // Supprime les messages d'erreur
      form.find(".wpcf7-validation-errors").remove(); // Supprime les erreurs générales
    }
  }

  // Ouvrir la modal avec la bonne référence photo
  openModalButtons.on("click", function () {
    const photoId = $(this).data("photo-id"); // Récupérer l'ID de la photo
    openModal(photoId);
  });

  // Fermer la modal en cliquant sur la croix
  closeButton.on("click", closeModal);

  openModalButtons.on("click", function (e) {
    e.preventDefault();
    const photoId = $(this).data("photo-id"); // Suppose que tu passes un ID de photo via un attribut data
    openModal(photoId);
  });

  // Événement pour fermer la modale
  closeButton.on("click", function () {
    closeModal();
  });

  // Fermer la modale en cliquant en dehors du contenu
  $(window).on("click", function (event) {
    if ($(event.target).is(modal)) {
      closeModal();
    }
  });

  // Fermer la modale via echape du clavier pour l'accessibilité
  $(document).on("keydown", function (e) {
    if (e.key === "Escape" && modal.hasClass("show")) {
      closeModal();
    }
  });

  // Réinitialise le formulaire au chargement de la page
  $(document).on("DOMContentLoaded", function () {
    closeModal(); // Ferme et réinitialise la modale au cas où elle serait ouverte après rafraîchissement
  });

  // Ouvre la modale quand on clique sur le lien "Contact"
  $(".contact-link").on("click", function (e) {
    e.preventDefault();
    openModal(); // Ouvre la modale
  });
});


// Préremplir la référence 
jQuery(document).ready(function($) {
    function openModal(photoRef) {
        var modal = $('#modal-contact');
        modal.addClass('show');
        
        // Pré-remplir le champ de référence photo
        var refPhotoField = modal.find('input#photoReferenceField');
        if (refPhotoField.length && photoRef) {
            refPhotoField.val(photoRef);
        }
    }

    // Ouvrir la modale quand on clique sur le lien "Contact"
    $('.contact-link').on('click', function(e) {
        e.preventDefault();
        var photoRef = $(this).data('photo-ref');
        openModal(photoRef);
    });

    // Fermer la modale
    $('.modal .close').on('click', function() {
        $('#modal-contact').removeClass('show');
    });

    // Fermer la modale en cliquant en dehors
    $(window).on('click', function(event) {
        if ($(event.target).is('#modal-contact')) {
            $('#modal-contact').removeClass('show');
        }
    });
});
