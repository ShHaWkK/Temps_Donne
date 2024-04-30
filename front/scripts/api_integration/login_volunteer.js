function loginVolunteer(){
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var data = {
        "email": email,
        "password": password,
        "role": "Benevole"
    };

    var apiUrl = 'http://localhost:8082/index.php/login';


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
                // Redirection vers la page souhaitée
                window.location.href = "../../volunteers/header.php";
            }
        })
        .catch(error => {
            console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API :', error.message);
        });


}

document.getElementById('validationButton').addEventListener('click', function(event) {
    // Empêcher le comportement par défaut du bouton
    event.preventDefault();

    loginVolunteer();
});