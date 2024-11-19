document.addEventListener('DOMContentLoaded', function() {
     const lightboxIcons = document.querySelectorAll('.lightbox-icon');
     const lightboxModal = document.getElementById('lightbox-modal');
     const lightboxImage = document.getElementById('lightbox-image');
     const closeLightbox = document.querySelector('.close-lightbox');
 
     // Ouvrir la lightbox au clic sur l'icône
     lightboxIcons.forEach(icon => {
         icon.addEventListener('click', function(event) {
             event.preventDefault();
             const imageUrl = icon.getAttribute('data-img'); // Récupère l'URL de l'image
             lightboxImage.src = imageUrl;
             lightboxModal.style.display = 'flex'; // Affiche la modale
         });
     });
 
     // Fermer la lightbox au clic sur le bouton de fermeture
     closeLightbox.addEventListener('click', function() {
         lightboxModal.style.display = 'none';
         lightboxImage.src = ''; // Vide la source de l'image pour éviter un rechargement inutile
     });
 
     // Fermer la lightbox au clic en dehors de l'image
     lightboxModal.addEventListener('click', function(event) {
         if (event.target === lightboxModal) {
             lightboxModal.style.display = 'none';
             lightboxImage.src = '';
         }
     });
 });
 