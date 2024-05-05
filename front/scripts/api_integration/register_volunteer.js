function sendDataToAPI() {
    // Récupérer les valeurs des permis cochés
    var driverLicenseChecked = document.getElementById('driverLicenseCheckbox').checked;
    var heavyLicenseChecked = document.getElementById('heavyLicenseCheckbox').checked;
    var cacesChecked = document.getElementById('cacesCheckbox').checked;
    console.log(driverLicenseChecked);

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
        "Role": "Benevole",
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
            return response.json(); // Analyser la réponse JSON
        })
        .then(data => {
            // Afficher la réponse JSON dans une alerte
            alert(JSON.stringify(data));
            if (data && data.status && data.status.startsWith("success")) {
                // Redirection vers la page souhaitée
                //window.location.href = "../../index.php";
                const userId = data["inserted id"];
                addSelectedSkills(userId);
                return data; // Passer les données pour le traitement suivant si nécessaire
            } else {
                throw new Error(data.message || "Erreur lors de l'enregistrement de l'utilisateur.");
            }
        })
        .catch(error => {
            //console.error('Erreur lors de l\'enregistrement de l\'utilisateur :', error.message);
            alert('Erreur lors de l\'enregistrement de l\'utilisateur :', error.message);
        });
}

function sendPDFFile(inputId, formData, maxFileSize, maxFileNameLength) {
    console.log("On est dans sendPDFFile");
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
            .then(data => {
                if (data && data.status === "success") {
                    console.log(`Compétence ${skillId} assignée à l'utilisateur ${userId}.`);
                } else {
                    throw new Error(data.message || "Erreur lors de l'assignation de la compétence.");
                }
            })
            .catch(error => {
                console.error(`Erreur lors de l'assignation de la compétence ${skillId} :`, error.message);
                alert(`Erreur lors de l'assignation de la compétence ${skillId} :`, error.message);
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