async function deleteUser(user_id) {
    const apiUrl = 'http://localhost:8082/index.php/users/' + user_id;
    console.log("On entre dans deleteUser");
    console.log("apiURL",apiUrl);
    const options = {
        method: 'DELETE'
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