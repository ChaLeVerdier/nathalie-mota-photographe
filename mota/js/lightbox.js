jQuery(document).ready(function ($) {
   const lightbox = $("#photo-lightbox");
   const lightboxImage = $("#lightbox-image");
   const lightboxReference = $("#lightbox-reference");
   const lightboxCategory = $("#lightbox-category");
   const closeButton = $(".photo-lightbox__close");
   const prevButton = $("#prev-photo");
   const nextButton = $("#next-photo");


   let photos = []; // Liste des images dans la galerie
   let currentIndex = 0; // Index de l'image actuellement affichée


   // Fonction pour mettre à jour la liste des images disponibles
   function updatePhotos() {
       photos = $(".open-lightbox"); // Récupère toutes les images avec la classe .open-lightbox
       console.log(`Photos mises à jour : ${photos.length}`, photos);
   }


   // Fonction pour afficher une photo dans la lightbox
   function showPhoto(index) {
       const photo = photos.eq(index); // Récupère la photo correspondante
       if (!photo.length) {
           console.warn(`Aucune photo trouvée pour l'index ${index}`);
           return;
       }


       console.log(`Affichage de la photo à l'index ${index}:`, photo);
       lightboxImage.attr("src", photo.data("img"));
       lightboxImage.attr("alt", photo.data("title"));
       lightboxReference.text(photo.data("reference"));
       lightboxCategory.text(photo.data("category"));


       lightbox.removeClass("hidden");
   }


   // Gestion des clics sur une image pour ouvrir la lightbox
   $(document).on("click", ".open-lightbox", function (e) {
       e.preventDefault();


       // Réinitialiser la liste des photos avant d'afficher
       updatePhotos();
       currentIndex = photos.index(this); // Met à jour l'index actuel
       console.log(`Image cliquée :`, this);
       console.log(`Index actuel après clic : ${currentIndex}`);
       showPhoto(currentIndex); // Affiche la photo
   });


   // Navigation vers la photo suivante
   nextButton.on("click", function (e) {
       e.preventDefault();
       if (!photos.length) return;
       currentIndex = (currentIndex + 1) % photos.length; // Passe à l'image suivante
       console.log(`Bouton "Suivant" cliqué. Nouvel index : ${currentIndex}`);
       showPhoto(currentIndex); // Affiche la nouvelle image
   });


   // Navigation vers la photo précédente
   prevButton.on("click", function (e) {
       e.preventDefault();
       if (!photos.length) return;
       currentIndex = (currentIndex - 1 + photos.length) % photos.length; // Revient à l'image précédente
       console.log(`Bouton "Précédent" cliqué. Nouvel index : ${currentIndex}`);
       showPhoto(currentIndex); // Affiche la nouvelle image
   });


   // Fermeture de la lightbox
   closeButton.on("click", function () {
       console.log("Bouton de fermeture cliqué.");
       lightbox.addClass("hidden");
   });


   // Fermer la lightbox en cliquant à l'extérieur
   lightbox.on("click", function (e) {
       if ($(e.target).is(lightbox)) {
           console.log("Clique à l'extérieur de la lightbox. Fermeture.");
           lightbox.addClass("hidden");
       }
   });


   // Fermer la lightbox avec la touche Échap
   $(document).on("keydown", function (e) {
       if (e.key === "Escape" && !lightbox.hasClass("hidden")) {
           console.log("Touche Échap pressée. Fermeture de la lightbox.");
           lightbox.addClass("hidden");
       }
   });


   // Mise à jour des images après un filtrage ou un chargement supplémentaire
   $(document).on("photosUpdated", function () {
       console.log("Événement 'photosUpdated' déclenché. Mise à jour de la liste des photos.");
       updatePhotos();
   });


   // Initialisation des photos au chargement de la page
   updatePhotos();
});


