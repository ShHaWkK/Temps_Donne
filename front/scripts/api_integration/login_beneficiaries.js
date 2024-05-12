document.write('<script src="../../scripts/getCookie.js"></script>');
function loginBeneficiaire(){
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var data = {
        "email": email,
        "password": password,
        "role": "Beneficiaire"
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
            // alert(JSON.stringify(data));
            if (data && data.status && data.status.startsWith("success")) {
                // Récupérer le token de session
                var sessionToken = data.session_token;
                var userId = data.user_id;

                // Créer un cookie avec le nom 'session_token'
                document.cookie = 'session_token=' + sessionToken + '; path=/; max-age=86400';
                document.cookie = 'user_id=' + userId + '; path=/; max-age=86400';

                console.log('getCookieSession',getCookie('session_token'));
                console.log('sessionToken',sessionToken);
                console.log('getCookieID',getCookie('user_id'));
                console.log('userId',userId);

                alert("Connection success");

                // Vérifier si les cookies ont été attribués correctement
                if (getCookie('session_token') === sessionToken && parseInt(getCookie('user_id'), 10) === userId) {
                    // Redirection vers la page souhaitée
                    window.location.href = "../../beneficiaries/planning.php";
                } else {
                    console.error("Les cookies n'ont pas été créés ou existent déjà.");
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API :', error.message);
            window.location.href = "../../inscription_conn/connexion_beneficiaire.php";
        });
}

document.getElementById('validationButton').addEventListener('click', function(event) {
    // Empêcher le comportement par défaut du bouton
    event.preventDefault();

    loginBeneficiaire();
});