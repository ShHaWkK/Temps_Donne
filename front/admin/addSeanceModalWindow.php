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

            <label for="startDate">Date de début:</label>
            <input type="date" id="startDate" name="startDate" value="12-09-2024" required><br><br>

            <label for="endDate">Date de fin:</label>
            <input type="date" id="endDate" name="endDate" value="12-12-2024" required><br><br>

            <table id="usersTable">
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        displayUsers();
                        console.log("Inside select");
                    });
                </script>
            </table><br><br>

            <input class="confirm-button" id="confirm-button-addSeance" type="submit" value="Ajouter">
        </form>
    </div>
</div>

<script>
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
