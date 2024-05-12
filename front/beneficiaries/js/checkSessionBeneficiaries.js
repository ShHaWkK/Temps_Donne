function checkSession() {
    var apiUrl = 'http://localhost:8082/index.php/login';


    var data = {
        "role": "Beneficiaire"
    };

    var options = {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    // Retourner la promesse créée par fetch()
    return fetch(apiUrl, options)
        .then(response => {
            return response.json(); // Analyser la réponse JSON
        })
        .then(data => {
            if (data && data.status && data.status.startsWith("success")) {
                console.log("Session ouverte");
            } else {
                window.location.href = "../inscription_conn/connexion_beneficiaire.php";
            }
        })
        .catch(error => {
            //console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API :', error.message);
            window.location.href = "./login.php";
        });
}