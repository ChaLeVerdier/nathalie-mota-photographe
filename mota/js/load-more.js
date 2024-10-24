let photosChargées = 0; // Nombre de photos déjà affichées
const photosParChargement = 8; // Nombre de photos à charger à chaque clic

// Au clic du bouton 'charger plus', appeler la fonction fetchPhotos
document.getElementById('charger-plus').addEventListener('click', () => {
    fetchPhotos();
});

// Fonction pour récupérer et afficher les photos
function fetchPhotos() {
    const apiUrl = `http://nathalie-mota-photographe.local/wp-json/wp/v2/media?per_page=${photosParChargement}&offset=${photosChargées}`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('photo-container'); // Assure-toi d'avoir ce conteneur dans ton HTML
            
            // Afficher les photos récupérées
            data.forEach(photo => {
                const photoDiv = document.createElement('div');
                photoDiv.classList.add('photo-item');
                photoDiv.innerHTML = `<img src="${photo.source_url}" alt="${photo.alt_text || 'Photo'}">`;
                container.appendChild(photoDiv);
            });

            // Mettre à jour le nombre de photos chargées
            photosChargées += data.length;

            // Vérifie si toutes les photos sont chargées ou si moins que prévu sont renvoyées
            if (data.length < photosParChargement) {
                document.getElementById('charger-plus').disabled = true;
                document.getElementById('charger-plus').innerText = 'Plus de photos à charger';
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des photos:', error);
        });
}

// Charger les photos initiales au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    fetchPhotos();
});
