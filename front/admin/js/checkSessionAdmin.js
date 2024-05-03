function checkSession() {
    var apiUrl = 'http://localhost:8082/index.php/login';

    var options = {
        method: 'POST',
        credentials: 'include'
    };

    // Retourner la promesse créée par fetch()
    return fetch(apiUrl, options)
        .then(response => {
            if (!response.ok) {
                return response.text().then(errorMessage => {
                    throw new Error(errorMessage || 'Erreur inattendue.');
                    window.location.href = "./login.php";
                });
            }
            return response.json(); // Analyser la réponse JSON
        })
        .then(data => {
            if (data && data.status && data.status.startsWith("success")) {
                console.log("Session ouverte");
            } else {
                window.location.href = "./login.php";
            }
        })
        .catch(error => {
            //console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API :', error.message);
            window.location.href = "./login.php";
        });
}