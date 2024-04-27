function loginVolunteer() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var data = {
        "Email": email,
        "Mot_de_passe": password,
        "Role": "Benevole"
    }

    var apiUrl = 'http://localhost:8082/index.php/login';

    // Options de la requête HTTP
    var options = {
        method: 'POST',
        body: data
    };

    fetch(apiUrl, options)
        .then(response => {
            if (!response.ok) {
                return response.text().then(errorMessage => {
                    throw new Error(errorMessage || 'Erreur inattendue.');
                });
            }
            //return response();
        })
        .then(data => {
            alert('Succès ! Bienvenue sur votre compte.');
        })
        .catch(error => {
            console.error('Erreur lors de la réponse de l\'API :', error);
            alert('Erreur lors de la réponse de l\'API :', error);
        });

}

document.getElementById('validationButton').addEventListener('click', function(event) {
    // Empêcher le comportement par défaut du bouton
    event.preventDefault();

    loginVolunteer();
});