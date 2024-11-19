// Script pour le menu hamburger
document.addEventListener('DOMContentLoaded', function() {
     console.log('Script pour le menu hamburger chargé avec succès !');
 
     const hamburger = document.querySelector('.hamburger');
     const mobileMenu = document.querySelector('.mobile-menu');
     const body = document.body;
 
     if (!hamburger) {
         console.log('Erreur : Élément ".hamburger" introuvable dans le DOM');
         return;
     }
     if (!mobileMenu) {
         console.log('Erreur : Élément ".mobile-menu" introuvable dans le DOM');
         return;
     }
 
     hamburger.addEventListener('click', function() {
         console.log('Clic sur le bouton hamburger détecté');
 
         // Basculer les classes
         hamburger.classList.toggle('active');
         mobileMenu.classList.toggle('active');
 
         console.log('État du hamburger:', hamburger.classList.contains('active')); // Vérifie si 'active' est bien ajouté au hamburger
         console.log('État du menu mobile:', mobileMenu.classList.contains('active')); // Vérifie si 'active' est bien ajouté au mobileMenu
 
         // Bloquer ou débloquer le défilement du body
         if (mobileMenu.classList.contains('active')) {
             body.classList.add('no-scroll');
             console.log('Menu mobile actif, défilement désactivé');
         } else {
             body.classList.remove('no-scroll');
             console.log('Menu mobile inactif, défilement réactivé');
         }
     });

 // Fonction pour fermer la modale si la largeur de la fenêtre dépasse 782px
 function checkWindowSize() {
     if (window.innerWidth > 782) {
         // Retire les classes 'active' pour fermer le menu
         hamburger.classList.remove('active');
         mobileMenu.classList.remove('active');
         body.classList.remove('no-scroll');
         console.log('Largeur de fenêtre > 782px, fermeture automatique du menu mobile');
     }
 }

 // Vérifie la taille de la fenêtre au chargement
 checkWindowSize();

 // Ajoute un écouteur d'événements pour surveiller les changements de taille de la fenêtre
 window.addEventListener('resize', checkWindowSize);
});


