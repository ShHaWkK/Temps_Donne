<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un service</title>
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<div id="addServiceTypeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Ajouter un service</h2>
        <form id="serviceForm" action="#" method="post">

            <label for="serviceName">Nom du type de service :</label>
            <input type="text" id="serviceName" name="serviceName" required><br><br>

            <label for="serviceDescription">Description :</label>
            <textarea id="serviceDescription" name="serviceDescription" required></textarea><br><br>

            <input class="confirm-button" id="confirm-button-addServiceType" type="submit" value="Ajouter">
        </form>
    </div>
</div>

<script>
    console.log("On est dans addServiceTypeModal");
    // Fonction pour ouvrir la fenêtre modale
    function openAddServiceTypeModal() {
        document.getElementById('addServiceTypeModal').style.display = 'block';
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        const modal = document.getElementById('addServiceTypeModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Écouter les messages envoyés par l'iframe parent
    window.addEventListener('message', function(event) {
        if (event.data === 'openAddServiceTypeModal') {
            openAddServiceTypeModal();
        }
    });
</script>

</body>
</html>