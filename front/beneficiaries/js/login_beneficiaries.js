document.write('<script src="../../scripts/getCookie.js"></script>');
function loginAdmin() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var data = {
        "email": email,
        "password": password,
        "role": "Administrateur"
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
            // Gérer les réponses non réussies
            if (!response.ok) {
                return response.text().then(errorMessage => {
                    throw new Error(errorMessage || 'Erreur inattendue.');
                });
            }
            // Analyser la réponse JSON
            return response.json();
        })
        .then(data => {
            // Gérer la réponse JSON
            if (data && data.status && data.status.startsWith("success")) {
                var sessionToken = data.session_token;
                var userId = data.user_id;

                // Créer des cookies avec les informations reçues
                document.cookie = 'session_token=' + sessionToken + '; path=/; max-age=86400';
                document.cookie = 'user_id=' + userId + '; path=/; max-age=86400';

                // Vérifier si les cookies ont été créés correctement
                if (getCookie('session_token') === sessionToken && parseInt(getCookie('user_id'), 10) === userId) {
                    alert("Connexion réussie");
                    window.location.href = "./users.php";
                } else {
                    console.error("Les cookies n'ont pas été créés ou existent déjà.");
                }
            } else {
                console.error("Réponse de l'API inattendue :", data);
                alert(data);
            }
        })
        .catch(error => {
            // Gérer les erreurs
            console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API : ' + error.message);
        });
}

document.getElementById('validationButton-beneficiaries').addEventListener('click', function(event) {
    // Empêcher le comportement par défaut du bouton
    event.preventDefault();

    loginAdmin();
});