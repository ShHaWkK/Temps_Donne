function addHoldEventListeners() {
    console.log("holdevnet");
    document.querySelectorAll('.hold-link').forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            const userId = link.closest('tr').querySelector('.user-id').textContent.trim();

            try {
                await putOnHoldUser(userId);
            } catch (error) {
                console.error('Erreur lors de la mise en attente de l\'utilisateur:', error);
            }
        });
    });
}
async function putOnHoldUser(user_id) {
    const apiUrl = 'http://localhost:8082/index.php/admins/' + user_id + '/hold';
    console.log("On entre dans hold");
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
        // Recharger la page après l'approbation de l'utilisateur
        window.location.reload();
    } catch (error) {
        console.error('Error :', error);
        alert('Error : ',error);
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}