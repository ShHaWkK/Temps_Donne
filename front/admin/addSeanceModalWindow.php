<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<div id="addSeanceModal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-add-seance">&times;</span>
        <h2>Ajouter une séance</h2>
        <form id="seanceForm" action="#" method="post">

            <label for="seanceName">Titre de la séance :</label>
            <input type="text" id="seanceName" name="seanceName"  value="Séance" required><br><br>

            <label for="seanceDescription">Description :</label>
            <textarea id="seanceDescription" name="seanceDescription" content="Séance" required></textarea><br><br>

            <label for="seanceDate">Date:</label>
            <input type="date" id="seanceDate" name="seanceDate" required><br><br>

            <label for="startTime">Heure de début:</label>
            <input type="time" id="startTime" name="startTime" required><br><br>

            <label for="endTime">Heure de fin:</label>
            <input type="time" id="endTime" name="endTime" required><br><br>

            <input class="confirm-button" id="confirm-button-addSeance" onclick="addSeance()" TYPE="submit" value="Ajouter">
        </form>
    </div>
</div>

<script>
    async function addSeance() {
        var apiUrl = "http://localhost:8082/index.php/formations/sessions";

        // Récupérer les valeurs des champs du formulaire
        var titre = document.getElementById('seanceName').value;
        var description = document.getElementById('seanceDescription').value;
        var startTime = document.getElementById('startTime').value;
        var endTime = document.getElementById('endTime').value;
        var seanceDate = document.getElementById('seanceDate').value;

        // Créer un objet JSON avec les données du formulaire
        const data = {
            "Titre": titre,
            "Description": description,
            "Date": seanceDate,
            "Heure_Debut_Seance": startTime,
            "Heure_Fin_Seance": endTime,
            "ID_Salle": 1, 
            "ID_Formation": selectedFormation
        };

        // Options de la requête HTTP
        var options = {
            method: 'POST',
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
                alert(JSON.stringify(data));
            })
            .catch(error => {
                console.error('Erreur lors de la réponse du serveur:', error.message);
                // alert('Erreur lors de la réponse du serveur:', error.message);
            });
    }

    console.log("On est dans addSeanceModal");

    // Fonction pour ouvrir la fenêtre modale
    function openAddSeanceModal() {
        document.getElementById('addSeanceModal').style.display = 'block';
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('addSeanceModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Ajouter un écouteur d'événement sur la soumission du formulaire
    document.getElementById('seanceForm').addEventListener('submit', function(event) {
        var startDate = new Date(document.getElementById('startDate').value + ' ' + document.getElementById('startDate').value);
        var endDate = new Date(document.getElementById('endDate').value + ' ' + document.getElementById('endDate').value);

        // Vérifier si la date de fin est postérieure à la date de début
        if (endDate <= startDate) {
            alert('La date de fin doit être ultérieure à la date de début.');
            event.preventDefault(); // Empêcher l'envoi du formulaire si la validation échoue
        }
    });

    // Écouter les messages envoyés par l'iframe parent
    window.addEventListener('message', function(event) {
        if (event.data === 'openAddSeanceModal') {
            openAddSeanceModal();
        }
    });

    document.getElementById('close-add-seance').addEventListener('click', function() {
        const modal = document.getElementById('addSeanceModal');
        modal.style.display = 'none';
    });
</script>

</body>
</html>
