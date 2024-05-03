function addRejectEventListeners() {
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
    console.log("On rentre dans rejectUser");
    const apiUrl = 'http://localhost:8082/index.php/admins/' + user_id + '/reject';
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
        displayUsers(displayedUsers);
    } catch (error) {
        console.error('Error :', error);
        alert('Error : ',error);
    }
}