function addInscriptionListener(){
    const confirmButton = document.getElementById('formationInscription');
    console.log("On est là");
    confirmButton.addEventListener('click', function(event) {
        console.log("click")
        event.preventDefault();
        registerFormation();
    });
}

function registerFormation() {
    var apiUrl = 'http://localhost:8082/index.php/formations/register';

    userId=getCookie('user_id');
    console.log(userId);
    console.log(selectedFormation);
    // Créer un objet JSON avec les données du formulaire
    const data = {
        "volunteerId": userId,
        "formationId":selectedFormation
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