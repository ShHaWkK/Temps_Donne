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
    var demi_journees = document.getElementById('heures').value;
    var lundi = document.getElementById('lundi').value;
    var mardi = document.getElementById('mardi').value;
    var mercredi = document.getElementById('mercredi').value;
    var jeudi = document.getElementById('jeudi').value;
    var vendredi = document.getElementById('vendredi').value;
    var samedi = document.getElementById('samedi').value;
    var dimanche = document.getElementById('dimanche').value;
    var permis_b = document.getElementById('driverLicenseCheckbox').checked;
    var permis_poids_lourd = document.getElementById('heavyLicenseCheckbox').checked;
    var caces = document.getElementById('cacesCheckbox').checked;
    var nationalite = document.getElementById('nationalite').value;

    // Créer un objet JSON avec les données du formulaire
    var data = {
        "Nom": nom,
        "Prenom": prenom,
        "Email": email,
        "Mot_de_passe": mot_de_passe,
        "Genre": genre,
        "Adresse": adresse,
        "Telephone": telephone,
        "Nationalite":nationalite,
        "Date_de_naissance": date_naissance,
        "Statut": "Pending",
        "Situation": situation,
        "Role": "Benevole",
        "Permis_B": permis_b,
        "Permis_Poids_Lourds": permis_poids_lourd,
        "CACES": caces,
        "DEMI_JOURNEES": demi_journees,
        "LUNDI": lundi,
        "MARDI": mardi,
        "MERCREDI": mercredi,
        "JEUDI": jeudi,
        "VENDREDI": vendredi,
        "SAMEDI": samedi,
        "DIMANCHE": dimanche
    };

    var formData = new FormData();
    formData.append('json_data', JSON.stringify(data)); // Ajouter les données JSON

    // Envoyer les fichiers PDF
    sendPDFFile('permis_file', formData, maxFileSize, maxFileNameLength);
    sendPDFFile('cv_file', formData, maxFileSize, maxFileNameLength);

    var apiUrl = 'http://localhost:8082/index.php/volunteers/register';

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
                addSelectedSkills(userId);
                window.location.href = "../../inscription_conn/connexion_benevole.php";
                return data;
            } else {
                // Jetez une erreur avec le message de la réponse JSON
                throw new Error(data.message || "Erreur lors de l'enregistrement de l'utilisateur.");
            }
        })
        .catch(error => {
            //console.error('Erreur lors de l\'enregistrement de l\'utilisateur :', error.message);
            alert('Erreur lors de l\'enregistrement de l\'utilisateur :', error.message);
        });
}

function sendPDFFile(inputId, formData, maxFileSize, maxFileNameLength) {
    const fileInput = document.getElementById(inputId);
    const file = fileInput.files[0];
    console.log("File input ID:", inputId);
    console.log("File:", file);
    if (!file){
    }else{
        formData.append(inputId, file, file.name);

        if (!isFileNameValid(file.name)) {
            alert("Le nom du fichier PDF contient des caractères interdits (espaces, caractères spéciaux)");
            throw new Error("Nom de fichier invalide : " + file.name);
        }

        if (!isFileSizeValid(file, maxFileSize)) {
            alert("La taille du fichier PDF dépasse la limite autorisée (10 Mo).");
            throw new Error("Taille de fichier invalide : " + file.size);
        }

        if (!isFileNameLengthValid(file.name, maxFileNameLength)) {
            alert("Le nom du fichier PDF dépasse la limite autorisée (50 caractères).");
            throw new Error("Longueur de nom de fichier invalide : " + file.name.length);
        }
    }
}

function addSelectedSkills(userId) {
    console.log("On est addSelectedSkills");
    // Récupérer les compétences sélectionnées par l'utilisateur
    var selectedSkills = document.querySelectorAll('input[name="competence"]:checked');
    console.log(selectedSkills);

    // Envoyer une requête POST pour chaque compétence sélectionnée
    selectedSkills.forEach(skill => {
        var skillId = skill.value;
        console.log("Skill ID:", skillId);
        var assignUrl = `http://localhost:8082/index.php/skills/assign/${userId}/${skillId}`;
        console.log("Assign URL:", assignUrl);

        fetch(assignUrl, { method: 'POST' })
            .then(response => response.json())
            .then(messages => {
                // On vérifie si des messages ont été retournés
                if (Array.isArray(messages) && messages.length > 0) {
                    // Parcourez chaque message et affichez-le dans la console
                    messages.forEach(message => console.log(message));
                } else {
                    // Si aucun message n'a été retourné, affichez un message par défaut
                    console.log("Aucun message retourné par l'API.");
                }
            })
            .catch(error => {
                // Affichez les erreurs dans la console
                console.error(`Erreur lors de l'assignation de la compétence ${skillId} :`, error.message);
                //alert(`Erreur lors de l'assignation de la compétence ${skillId} : ${error.message}`);
            });

    });
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