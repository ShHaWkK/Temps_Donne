
function sendDataToAPI() {
    // Récupérer les valeurs des champs du formulaire
    var genre = document.querySelector('input[name="genre"]:checked').value;
    var nom = document.getElementById('nom').value;
    var prenom = document.getElementById('prenom').value;
    var date_naissance = document.getElementById('date_naissance').value;
    var email = document.getElementById('email').value;
    var telephone = document.getElementById('telephone').value;
    var adresse = document.getElementById('adresse').value;
    var mot_de_passe = document.getElementById('mot_de_passe').value;
    var situation = document.getElementById('situation').value;

    // Récupérer les cases cochées pour les permis
    var permisArray = [];
    var permisCheckboxes = document.querySelectorAll('input[name="permis"]:checked');
    permisCheckboxes.forEach(function(checkbox) {
        permisArray.push(checkbox.value);
    });

    // Créer un objet JSON avec les données du formulaire
    var data = {
        "Nom": nom,
        "Prenom": prenom,
        "Email": email,
        "Mot_de_passe": mot_de_passe,
        "Genre": genre,
        "Adresse": adresse,
        "Telephone": telephone,
        "Date_de_naissance": date_naissance,
        "Statut": "Pending",
        "Situation": situation,
        "Role": "Benevole"

    };

    var jsonData = JSON.stringify(data);
    console.log("Contenu JSON envoyé :", jsonData);


    var formData = new FormData();
    formData.append('data', jsonData); // Ajouter les données JSON

    var permisInput = document.getElementById('permis_file');
    var permisFile = permisInput.files[0];
    formData.append('permis_file', permisFile);

    var cvInput = document.getElementById('CV');
    var cvFile = cvInput.files[0];
    formData.append('cv_file', cvFile);

    console.log("Contenu de FormData :", formData);

    var apiUrl = 'http://localhost:8082/index.php/volunteers/register';

    // Options de la requête HTTP
    var options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonData
    };

    // Envoyer les données à l'API via une requête HTTP POST
    fetch(apiUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de l\'envoi des données à l\'API.');
            }
            return response.json();
        })
        .then(data => {
            // Traiter la réponse de l'API ici, si nécessaire
            console.log('Réponse de l\'API :', data);
            alert(JSON.stringify(data)); // Afficher la réponse de l'API en tant qu'alerte
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données à l\'API :', error);
            alert('Erreur lors de l\'envoi des données à l\'API.');
        });

}

function getTodayDate() {
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0');
    var year = today.getFullYear();

    return year + '-' + month + '-' + day;
}
