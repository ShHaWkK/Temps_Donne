<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<div id="addServiceModal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-add-service">&times;</span>
        <h2>Ajouter un service</h2>
        <form id="serviceForm" action="#" method="post">

            <label for="serviceName">Nom du service :</label>
            <input type="text" id="serviceName" name="serviceName"  value="Service"required><br><br>

            <label for="serviceDescription">Description :</label>
            <textarea id="serviceDescription" name="serviceDescription" content="Service" required></textarea><br><br>

            <label for="serviceLocation">Adresse :</label>
            <input type="text" id="serviceLocation" name="serviceLocation" value="Service" required><br><br>

            <label for="serviceDate">Date :</label>
            <input type="date" id="serviceDate" name="serviceDate" value="12-12-2025" required><br><br>

            <label for="serviceTypeSelector">Type de service :</label>
            <select id="serviceTypeSelector" name="serviceTypeSelector" required>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        displayServiceTypes();
                        console.log("Inside select");
                    });
                </script>
            </select><br><br>

            <label for="serviceStartTime">Heure de début :</label>
            <input type="time" id="serviceStartTime" name="serviceStartTime" value="12:00" required><br><br>

            <label for="serviceEndTime">Heure de fin :</label>
            <input type="time" id="serviceEndTime" name="serviceEndTime" value="14:00" required><br><br>

            <input class="confirm-button" id="confirm-button-addService" type="submit" value="Ajouter">
        </form>
    </div>
</div>

<script>
    console.log("On est dans addServiceModal");

    // Fonction pour ouvrir la fenêtre modale
    function openAddFormationModal() {
        document.getElementById('addServiceModal').style.display = 'block';
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('addServiceModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Ajouter un écouteur d'événement sur la soumission du formulaire
    document.getElementById('serviceForm').addEventListener('submit', function(event) {
        var startDate = new Date(document.getElementById('serviceDate').value + ' ' + document.getElementById('serviceStartTime').value);
        var endDate = new Date(document.getElementById('serviceDate').value + ' ' + document.getElementById('serviceEndTime').value);

        // Vérifier si la date de fin est postérieure à la date de début
        if (endDate <= startDate) {
            alert('La date de fin doit être ultérieure à la date de début.');
            event.preventDefault(); // Empêcher l'envoi du formulaire si la validation échoue
        }
    });

    // Écouter les messages envoyés par l'iframe parent
    window.addEventListener('message', function(event) {
        if (event.data === 'openAddServiceModal') {
            openAddServiceModal();
        }
    });

    document.getElementById('close-add-service').addEventListener('click', function() {
        const modal = document.getElementById('addServiceModal');
        modal.style.display = 'none';
    });
</script>

</body>
</html>