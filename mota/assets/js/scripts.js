// Attendre que le DOM soit complètement chargé
document.addEventListener('DOMContentLoaded', () => {
     const contactModal = document.querySelector('.contact-modal'); // Récupérer la modal de contact
     const openButton = document.getElementById('open-contact-modal'); // ID du bouton qui ouvre la modal
     const closeButton = document.querySelector('.close-button'); // Classe pour le bouton de fermeture
 
     // Vérifier si la modal et le bouton d'ouverture existent
     if (!contactModal) {
         console.warn('Aucune modal trouvée avec la classe "contact-modal".');
         return; // Arrêter l'exécution si aucune modal n'est trouvée
     }
 
     if (!openButton) {
         console.warn('Aucun bouton trouvé pour ouvrir la modal.');
         return; // Arrêter l'exécution si aucun bouton n'est trouvé
     }
 
     if (!closeButton) {
         console.warn('Aucun bouton trouvé pour fermer la modal.');
         return; // Arrêter l'exécution si aucun bouton de fermeture n'est trouvé
     }
 
     // Fonction pour ouvrir la modal
     const openModal = () => {
         contactModal.style.display = 'block'; // Afficher la modal
     };
 
     // Fonction pour fermer la modal
     const closeModal = () => {
         contactModal.style.display = 'none'; // Masquer la modal
     };
 
     // Ouvrir la modal
     openButton.addEventListener('click', openModal);
 
     // Fermer la modal
     closeButton.addEventListener('click', closeModal);
 
     // Fermer la modal si l'utilisateur clique en dehors
     window.addEventListener('click', (event) => {
         if (event.target === contactModal) {
             closeModal(); // Masquer la modal si on clique sur le fond
         }
     });
 });
 