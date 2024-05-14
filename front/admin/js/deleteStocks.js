async function deleteStock() {
    const apiUrl = 'http://localhost:8082/index.php/stocks/' + selectedStock;
    console.log(selectedStock);
    const options = {
        method: 'DELETE'
    };

    try {
        const response = await fetch(apiUrl, options); // Attendre la réponse de la requête
        if (!response.ok) {
            const errorMessage = await response.json(); // Récupérer le message d'erreur de la réponse JSON
            throw new Error(errorMessage.error || 'Erreur inattendue'); // Lancer une erreur avec le message d'erreur
        }

        const data = await response.json(); // Attendre la conversion de la réponse en JSON
        console.log('Réponse du serveur:', data);
        alert(JSON.stringify(data));
        // Recharger la page après l'approbation de l'utilisateur
        window.location.reload();
    } catch (error) {
        console.error('Erreur :', error);
        alert('Erreur : ' + error.message); // Afficher le message d'erreur dans une alerte
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}


async function deleteExpiredStocks(displayedStocks) {
    console.log("confirmButtonDeleteExpired",displayedStocks);
    const apiUrlBase = 'http://localhost:8082/index.php/stocks/';

    // Filtrer les stocks périmés
    const expiredStocks = displayedStocks.filter(stock => {
        const expirationDate = new Date(stock.Date_de_peremption);
        return expirationDate < currentDate;
    });

    // Supprimer les stocks périmés et lancer une requête DELETE pour chaque stock périmé
    for (const expiredStock of expiredStocks) {
        const apiUrl = apiUrlBase + expiredStock.ID_Stock;
        try {
            const response = await fetch(apiUrl, { method: 'DELETE' });
            console.log('Réponse du serveur:', response);
            // Recharger la page après l'approbation de l'utilisateur
            window.location.reload();
        } catch (error) {
            console.error('Error :', error);
            alert('Error : ',error);
            window.location.reload();
        }
    }
    window.location.reload();
    return displayedStocks.filter(stock => !expiredStocks.includes(stock));
}
