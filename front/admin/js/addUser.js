function addAddUserEvent(){
    const confirmButton = document.getElementById('confirm-button-addUser');
    console.log("On est là");
    confirmButton.addEventListener('click', function(event) {
        event.preventDefault();
        addUser();
    });
}

function addUser() {
    var apiUrl = 'http://localhost:8082/index.php/users/register';

    // Récupérer les valeurs des champs du formulaire
    var genre = document.querySelector('select[name="genre"]').value;
    var nom = document.getElementById('nom').value;
    var prenom = document.getElementById('prenom').value;
    var date_naissance = document.getElementById('dateNaissance').value;
    var email = document.getElementById('email').value;
    var role = document.querySelector('select[name="role"]').value;
    var telephone = document.getElementById('telephone').value;
    var adresse = document.getElementById('adresse').value;
    var mot_de_passe = document.getElementById('motDePasse').value;
    var situation = document.getElementById('situation').value;
    var nationalite = document.getElementById('nationalite').value;
    var emploi = document.getElementById('emploi').value;
    var societe = document.getElementById('societe').value;
    var permis_b = document.getElementById('permis_b').checked;
    var caces = document.getElementById('caces').checked;
    var permis_poids_lourd = document.getElementById('permis_poids_lourd').checked;
    var status =document.querySelector('select[name="status"]').value;

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
        "Statut": status,
        "Situation": situation,
        "Nationalite":nationalite,
        "Emploi":emploi,
        "Societe":societe,
        "Permis_B":permis_b,
        "CACES":caces,
        "Permis_Poids_Lourds":permis_poids_lourd,
        "Role": role
    };

    // Créer un objet FormData pour envoyer les données du formulaire
    var formData = new FormData();
    formData.append('json_data', JSON.stringify(data)); // Ajouter les données JSON

    console.log(formData);

    // Options de la requête HTTP
    var options = {
        method: 'POST',
        body: formData
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
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API :', error.message);
        });
}