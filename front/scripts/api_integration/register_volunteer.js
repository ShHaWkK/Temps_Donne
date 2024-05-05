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

    var formData = new FormData();
    formData.append('json_data', JSON.stringify(data)); // Ajouter les données JSON

    var permisInput = document.getElementById('permis_file');
    var permisFile = permisInput.files[0];
    formData.append('permis_file', permisFile, permisFile.name);

    var cvInput = document.getElementById('CV');
    var cvFile = cvInput.files[0];
    formData.append('cv_file', cvFile, cvFile.name);

    if (!isFileNameValid(permisFile.name)) {
        alert("Le nom du pdf du permis contient des caractères interdits (espaces, caractères spéciaux)"+permisFile.name);
        return;
    }

    if (!isFileNameValid(cvFile.name)) {
        alert("Le nom du CV contient des caractères interdits (espaces, caractères spéciaux)");
        return;
    }

    if (!isFileSizeValid(permisFile, maxFileSize)) {
        alert("La taille du fichier du permis dépasse la limite autorisée (10 Mo).");
        return;
    }

    if (!isFileSizeValid(cvFile, maxFileSize)) {
        alert("La taille du fichier du CV dépasse la limite autorisée (10 Mo).");
        return;
    }

    if (!isFileNameLengthValid(permisFile.name, maxFileNameLength)) {
        alert("Le nom du fichier du permis dépasse la limite autorisée (50 caractères).");
        return;
    }

    if (!isFileNameLengthValid(cvFile.name, maxFileNameLength)) {
        alert("Le nom du fichier du CV dépasse la limite autorisée (50 caractères).");
        return;
    }

    var apiUrl = 'http://localhost:8082/index.php/volunteers/register';

    // Options de la requête HTTP
    var options = {
        method: 'POST',
        body: formData
    };

    console.log(options);
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
                window.location.href = "../../index.php";
            }
        })
        .catch(error => {
            console.error('Erreur lors de la réponse de l\'API :', error.message);
            alert('Erreur lors de la réponse de l\'API :', error.message);
        });

        //On récupére l'ID de l'utilisateur inséré:
        let userIdUrl ='http://localhost:8082/index.php/users/Mail/pa8@example.com'

        var apiCompetences = 'http://localhost:8082/index.php/volunteers/register';

}

function isFileNameValid(fileName) {
    var regex = /^[a-zA-Z0-9_()-. ]+\.pdf$/;
    return regex.test(fileName);
}

function isFileSizeValid(file, maxSizeInBytes) {
    return file.size <= maxSizeInBytes;
}

function isFileNameLengthValid(fileName, maxFileNameLength) {
    return fileName.length <= maxFileNameLength;
}

function getTodayDate() {
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0');
    var year = today.getFullYear();

    return year + '-' + month + '-' + day;
}