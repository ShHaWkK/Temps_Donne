async function deleteStock() {
    const apiUrl = 'http://localhost:8082/index.php/stocks/' + selectedStock;
    console.log("On entre dans deleteStocks",selectedStock);
    console.log("apiURL",apiUrl);
    const options = {
        method: 'DELETE'
    };

    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            throw new Error('Erreur lors de la requête');
        }

        const data = await response.json();
        console.log('Réponse du serveur:', data);
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
            alert(JSON.stringify(response));
            // Recharger la page après l'approbation de l'utilisateur
        } catch (error) {
            console.error('Error :', error);
            alert('Error : ',error);
            // Recharger la page en cas d'erreur
            window.location.reload();
        }
    }
    window.location.reload();
    return displayedStocks.filter(stock => !expiredStocks.includes(stock));
}
