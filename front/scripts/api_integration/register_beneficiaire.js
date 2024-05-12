function sendDataToAPI() {
    var maxFileSize = 10 * 1024 * 1024; // 10 Mo
    var maxFileNameLength = 50;

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
    var nationalite = document.getElementById('nationalite').value;

    // Créer un objet JSON avec les données du formulaire
    var data = {
        "Nom": nom,
        "Prenom": prenom,
        "Email": email,
        "Mot_de_passe": mot_de_passe,
        "Genre": genre,
        "Nationalite": nationalite,
        "Adresse": adresse,
        "Telephone": telephone,
        "Date_de_naissance": date_naissance,
        "Statut": "Pending",
        "Situation": situation,
        "Role": "Beneficiaire",
    };

    var formData = new FormData();
    formData.append('json_data', JSON.stringify(data)); // Ajouter les données JSON


    var apiUrl = 'http://localhost:8082/index.php/beneficiaries/register';

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
            console.log("response",response);
            return response.json(); // Analyser la réponse JSON

        })
        .then(data => {
            // Afficher la réponse JSON dans la console
            console.log(JSON.stringify(data));

            if (data && data.status === "success") {
                alert("Demande correctement envoyée, en attente de validation");
                const userId = data["inserted_id"];
                console.log(userId);
                window.location.href = "../../inscription_conn/connexion_beneficiaire.php";
                return data;
            } else {
                alert(data.error);
                throw new Error(data.message || "Erreur lors de l'enregistrement de l'utilisateur.");
            }
        })
}