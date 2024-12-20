jQuery(document).ready(function ($) {
    const modal = $("#modal-contact");
    const openModalButtons = $(".open-modal, .contact-link"); // Boutons pour ouvrir la modale
    const photoReferenceField = modal.find('input[name="photo-reference"]'); // Champ de référence photo
    const form = modal.find(".wpcf7-form"); // Formulaire Contact Form 7

    // Assurez-vous que la modale est masquée par défaut
    modal.addClass("hidden");

    // Fonction pour ouvrir la modale
    function openModal(photoRef) {
        modal.removeClass("hidden").addClass("show"); // Affiche la modale

        // Insérer la référence dans le champ "photo-reference" si disponible
        if (photoReferenceField.length && photoRef) {
            photoReferenceField.val(photoRef);
            console.log(`Référence photo insérée : ${photoRef}`);
        } else {
            console.warn("Champ de référence photo non trouvé ou référence non fournie");
        }
    }

    // Fonction pour fermer la modale
    function closeModal() {
        modal.removeClass("show").addClass("hidden"); // Cache la modale

        // Réinitialiser le formulaire et supprimer les erreurs de validation
        if (form.length) {
            form[0].reset(); // Réinitialise le formulaire
            form.find(".wpcf7-not-valid-tip").remove(); // Supprime les messages d'erreur
            form.find(".wpcf7-validation-errors").remove(); // Supprime les erreurs générales
        }
    }

    // Ouvrir la modale au clic sur un bouton
    openModalButtons.on("click", function (e) {
        e.preventDefault();
        const photoRef = $(this).data("reference"); // Récupère la référence photo depuis l'attribut data
        openModal(photoRef);
    });

    // Fermer la modale en cliquant en dehors du contenu
    $(document).on("click", function (event) {
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

    // Réinitialiser la modale au chargement de la page
    $(window).on("load", closeModal);
});
