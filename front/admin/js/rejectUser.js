function addRejectEventListeners() {
    console.log("rejectevent");
    document.querySelectorAll('.reject-link').forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            console.log("On ajoute le reject event listerner");
            const userId = link.closest('tr').querySelector('.user-id').textContent.trim();

            // Appeler la fonction approveUser avec l'ID utilisateur
            try {
                await rejectUser(userId);
            } catch (error) {
                console.error('Erreur lors du rejet de l\'utilisateur:', error);
            }
        });
    });
}
async function rejectUser(user_id) {
    const apiUrl = 'http://localhost:8082/index.php/admins/' + user_id + '/reject';
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
        // Recharger la page après l'approbation de l'utilisateur
        // window.location.reload();
        //window.parent.postMessage({ type: 'deleteUserModal'}, '*');
    } catch (error) {
        console.error('Error :', error);
        alert('Error : ',error);
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}