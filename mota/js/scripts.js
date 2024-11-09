jQuery(document).ready(function ($) {
  const modal = $("#modal-contact");
  const openModalButtons = $(".open-modal, .contact-link"); // Boutons pour ouvrir la modale
  const closeButton = modal.find(".close");
  const photoReferenceField = modal.find('input[name="photo-reference"]'); // Champ de référence photo
  const form = modal.find(".wpcf7-form"); // Formulaire Contact Form 7

  // Fonction pour ouvrir la modale et insérer la référence
  function openModal(photoRef) {
      modal.addClass("show"); // Affiche la modale

      // Insérer la référence dans le champ "photo-reference" si le champ est trouvé
      if (photoReferenceField.length && photoRef) {
          photoReferenceField.val(photoRef);
          console.log(photoReferenceField.val());
         
      } else {
          console.warn("Champ de référence photo non trouvé ou référence non fournie");
      }
  }

  // Fonction pour fermer la modale
  function closeModal() {
      modal.removeClass("show"); // Cache la modale

      // Réinitialiser le formulaire et supprimer les erreurs de validation
      if (form.length) {
          form[0].reset(); // Réinitialise le formulaire
          form.find(".wpcf7-not-valid-tip").remove(); // Supprime les messages d'erreur
          form.find(".wpcf7-validation-errors").remove(); // Supprime les erreurs générales
      }
  }

  // Ouvrir la modale au clic sur un bouton avec la référence photo
  openModalButtons.on("click", function (e) {
      e.preventDefault();
      const photoRef = $(this).data("reference"); // Récupère la référence photo depuis l'attribut data
      openModal(photoRef);
      console.log (photoRef);
  });

  // Fermer la modale au clic sur le bouton de fermeture
  closeButton.on("click", closeModal);

  // Fermer la modale en cliquant en dehors du contenu
  $(window).on("click", function (event) {
      if ($(event.target).is(modal)) {
          closeModal();
      }
  });

  // Fermer la modale avec la touche Échap pour l'accessibilité
  $(document).on("keydown", function (e) {
      if (e.key === "Escape" && modal.hasClass("show")) {
          closeModal();
      }
  });

  // Réinitialiser le formulaire au chargement de la page
  $(document).on("DOMContentLoaded", closeModal);
});
