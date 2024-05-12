function totalWeightCalculation(product_id,quantity){
    console.log("totalWeightCalculation",product_id);
    let weight=getProductWeight(allProduits,product_id);
    return weight * quantity;
}

function totalVolumeCalculation(product_id,quantity){
    let volume=getProductVolume(allProduits,product_id);
    return volume * quantity;
}

function addAddStockEvent(){
    const confirmButton = document.getElementById('confirm-button-addStock');
    confirmButton.addEventListener('click', function(event) {
        event.preventDefault();
        addStock();
    });
}

function addStock() {
    var apiUrl = 'http://localhost:8082/index.php/stocks';

    // Récupérer les valeurs des champs du formulaire
    var id_entrepots = document.querySelector('select[name="entrepotSelector"]').value;
    var id_produit = document.querySelector('select[name="productSelector"]').value;
    var quantite = document.getElementById('quantity').value;
    var status = document.querySelector('select[name="status"]').value;
    var datePeremption = document.getElementById('datePeremption').value;
    var dateReception = currentDate.toISOString().split('T')[0];
    var volumeTotal= totalVolumeCalculation(id_produit,quantite);
    var poidsTotal = totalWeightCalculation(id_produit,quantite);

    // Créer un objet JSON avec les données du formulaire
    const data = {
        "ID_Entrepots": id_entrepots,
        "ID_Produit": id_produit,
        "Quantite": quantite,
        "Poids_Total": poidsTotal,
        "Volume_Total": volumeTotal,
        "Statut": status,
        "Date_de_reception":dateReception,
        "Date_de_peremption": datePeremption,
    };

    console.log(data);

    // Options de la requête HTTP
    var options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    fetch(apiUrl, options)
        .then(response => {
            if (!response.ok) {
                return response.text().then(errorMessage => {
                    throw new Error(errorMessage || 'Erreur inattendue.');
                });
            }
            return response.json(); // Analyser la réponse JSON
        })
        .then(data => {
            // Afficher la réponse JSON dans une alerte
            alert(JSON.stringify(data));
            if (data && data.status && data.status.startsWith("success")) {
                window.location.reload();
                console.log("success");
            }
        })
        .catch(error => {
            console.error('Erreur:', error.message);
            alert('Erreur:', error.message);
        });
}