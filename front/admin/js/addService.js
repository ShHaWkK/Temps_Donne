function addAddServiceEvent(){
    const confirmButton = document.getElementById('confirm-button-addService');
    console.log("On est là");
    confirmButton.addEventListener('click', function(event) {
        console.log("click")
        event.preventDefault();
        addService();
    });
}

function addService() {
    //On récupére le type de service sélectionné
    var selectElement = document.getElementById('serviceTypeSelector');
    var selectedValue = selectElement.value;
    var apiUrl = 'http://localhost:8082/index.php/services/'+selectedValue;

    // Récupérer les valeurs des champs du formulaire
    var nom = document.getElementById('serviceName').value;
    var description = document.getElementById('serviceDescription').value;
    var lieu = document.getElementById('serviceLocation').value;
    var date = document.getElementById('serviceDate').value;
    var id_serviceType = document.querySelector('select[name="serviceTypeSelector"]').value;
    var startTime = document.getElementById('serviceStartTime').value;
    var endTime = document.getElementById('serviceEndTime').value;

    // Créer un objet JSON avec les données du formulaire
    const data = {
        "Nom_du_service": nom,
        "Description": description,
        "Lieu": lieu,
        "Date": date,
        "ID_ServiceType": id_serviceType,
        "startTime": startTime,
        "endTime": endTime,
    };

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
                alert("success");
                window.location.reload();
                console.log("success");
            }
        })
        .catch(error => {
            console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API :', error.message);
        });
}