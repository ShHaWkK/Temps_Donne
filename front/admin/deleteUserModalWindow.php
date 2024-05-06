<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de suppression</title>
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h2>Suppression</h2>
        <p>Voulez-vous supprimer cet utilisateur ?</p>
        <div>
            <button class="confirm-button" id="confirmButtonDelete">Confirmer</button>
            <button class="cancel-button" id="cancelButton">Annuler</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirmButtonDelete').addEventListener('click', function() {
        var userId = event.data.userId; // Capturer la valeur de event.data.userId
        console.log(userId);
        deleteUser(userId);
    });


    // Fonction pour ouvrir la fenêtre modale
    function openDeleteModal(userId) {
        document.getElementById('deleteModal').style.display = 'block';
        // Mettre à jour le contenu ou effectuer toute autre action nécessaire en fonction de userId
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    window.addEventListener('message', function(event) {
        if (event.data.type === 'deleteUserModal') {
            openDeleteModal(event.data.userId);
        }
    });

</script>
</body>
</html>