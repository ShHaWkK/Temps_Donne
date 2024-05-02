// Sélectionnez tous les liens avec l'attribut href égal à '#'
const approveLinks = document.querySelectorAll('a[href="#Valider"]');

// Parcourez chaque lien et ajoutez un gestionnaire d'événements click
approveLinks.forEach(link => {
    link.addEventListener('click', async function(event) {
        // Empêchez le comportement par défaut du lien (par exemple, suivre le lien)
        event.preventDefault();

        // Récupérez l'ID de l'utilisateur à partir de l'attribut data-user-id
        const userId = this.dataset.userId;

        // Appelez la fonction approveUser avec l'ID de l'utilisateur
        try {
            await approveUser(userId);
            // Si la fonction est réussie, vous pouvez effectuer d'autres actions ici si nécessaire
        } catch (error) {
            console.error('Erreur lors de l\'approbation de l\'utilisateur:', error);
            // Gérez les erreurs ici si nécessaire
        }
    });
});

async function approveUser(user_id) {
    const apiUrl = 'http://localhost:8082/index.php/admins/' + user_id + '/approve';

    const options = {
        method: 'POST'
    };
    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            alert('Erreur réseau');
        }
        const data = await response.json();
        console.log(data);
        alert(data);
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        return [];
    }
}
