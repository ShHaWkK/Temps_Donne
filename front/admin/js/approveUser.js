function addApproveEventListeners() {
    document.querySelectorAll('.approve-link').forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault(); // Empêcher le comportement par défaut du lien

            // Récupérer l'ID utilisateur dans la même ligne
            const userId = link.closest('tr').querySelector('.user-id').textContent.trim();
            console.log('userID', userId);

            // Appeler la fonction approveUser avec l'ID utilisateur
            try {
                await approveUser(userId);
            } catch (error) {
                console.error('Erreur lors de l\'approbation de l\'utilisateur:', error);
            }
        });
    });
}
async function approveUser(user_id) {
    const apiUrl = 'http://localhost:8082/index.php/admins/' + user_id + '/approve';
    console.log("On entre dans approveUser");
    console.log("apiURL",apiUrl);
    const options = {
        method: 'PUT'
    };

    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            throw new Error('Erreur lors de la requête à l\'API');
        }

        const data = await response.json();
        console.log('Réponse de l\'API :', data);
        alert(JSON.stringify(data));
        getAllUsers(users);
    } catch (error) {
        console.error('Error :', error);
        alert('Error : ',error);
    }
}