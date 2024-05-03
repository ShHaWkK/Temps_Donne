const apiUrl = 'http://localhost:8082/index.php/login';

var data = {
    "role": "Benevole"
};

var options = {
    method: 'POST',
    credentials: 'include',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
};

fetch(apiUrl,options)
    .then(response => {
        if (!response.ok) {
            return response.text().then(errorMessage => {
                throw new Error(errorMessage || 'Erreur inattendue.');
                window.location.href = "../inscription_conn/connexion_benevole.php";
            });
        }
        return response.json(); // Analyser la réponse JSON
    })
    .then(data => {
        if (data && data.status && data.status.startsWith("success")) {
            console.log("Session ouverte");
        }else {
            window.location.href = "../inscription_conn/connexion_benevole.php";
        }
    })
    .catch(error => {
        //console.error('Erreur lors de la réponse de l\'API :', error.message);
        alert('Erreur lors de la réponse de l\'API :', error.message);
        window.location.href = "../inscription_conn/connexion_benevole.php";
    })