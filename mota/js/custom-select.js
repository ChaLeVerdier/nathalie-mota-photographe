document.addEventListener('DOMContentLoaded', function () {
     const customSelects = document.querySelectorAll('.custom-select');
  
  
     // Fonction pour fermer tous les menus ouverts
     function closeAllSelects() {
         customSelects.forEach((select) => {
             select.classList.remove('open');
         });
     }
  
  
     // Gérer les clics sur les custom-select
     customSelects.forEach((select) => {
         const selected = select.querySelector('.custom-selected');
         const optionsContainer = select.querySelector('.custom-options');
         const options = select.querySelectorAll('.custom-option');
  
  
         // Ouvrir/fermer le menu
         selected.addEventListener('click', (e) => {
             e.stopPropagation(); // Empêche le clic de se propager
             closeAllSelects(); // Ferme les autres menus
             select.classList.toggle('open'); // Bascule l'état actuel
         });
  
  
         // Sélectionner une option
         options.forEach((option) => {
             option.addEventListener('click', (e) => {
                 e.stopPropagation();
  
  
                 // Mettre à jour le texte et la valeur sélectionnés
                 selected.textContent = option.textContent;
                 selected.setAttribute('data-value', option.getAttribute('data-value'));
  
  
                 // Mettre à jour la classe sélectionnée
                 options.forEach((opt) => opt.classList.remove('is-selected'));
                 option.classList.add('is-selected');
  
  
                 // Fermer le menu
                 select.classList.remove('open');
  
  
                 // Déclencher le filtrage AJAX
                 fetchFilteredPhotos();
             });
         });
     });
  
  
     // Fermer tous les menus si clic en dehors
     document.addEventListener('click', closeAllSelects);
  
  
     // Fonction pour envoyer les filtres via AJAX
     function fetchFilteredPhotos() {
         const category = document.querySelector('.filter-categorie .custom-selected').getAttribute('data-value') || '';
         const format = document.querySelector('.filter-format .custom-selected').getAttribute('data-value') || '';
         const order = document.querySelector('.filter-date .custom-selected').getAttribute('data-value') || 'DESC';
  
  
         const galleryContainer = document.getElementById('gallery');
         const loadMoreButton = document.getElementById('load-more-btn');
  
  
         const data = new URLSearchParams({
             action: 'filter_photos',
             category: category,
             format: format,
             order: order,
         });
  
  
         fetch(ajaxurl, {
             method: 'POST',
             body: data,
             headers: {
                 'Content-Type': 'application/x-www-form-urlencoded',
             },
         })
             .then((response) => response.json())
             .then((data) => {
                 if (data.success && galleryContainer) {
                     galleryContainer.innerHTML = data.data.html;
  
  
                     if (loadMoreButton) {
                         loadMoreButton.dataset.page = 2;
                         loadMoreButton.dataset.maxPages = data.data.max_pages;
  
  
                         if (data.data.max_pages <= 1) {
                             loadMoreButton.style.display = 'none';
                         } else {
                             loadMoreButton.style.display = 'block';
                         }
                     }
                 } else {
                     galleryContainer.innerHTML = '<p>Aucune photo trouvée.</p>';
                     if (loadMoreButton) {
                         loadMoreButton.style.display = 'none';
                     }
                 }
             })
             .catch((error) => {
                 console.error('Erreur lors du filtrage :', error);
             });
     }
  });
  
  
  