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
        <span class="close">&times;</span>
        <h2>Suppression</h2>
        <p>Voulez-vous supprimer cet utilisateur ?</p>
        <div>
            <button class="confirm-button" id="confirmButtonDelete">Confirmer</button>
            <button class="cancel-button" id="cancelButtonDelete">Annuler</button>
        </div>
    </div>
</div>

<script>
    let user_id_delete;
    document.getElementById('confirmButtonDelete').addEventListener('click', function(event) {
        // Utilisez event.data.userId pour accéder à l'ID de l'utilisateur
        console.log(user_id_delete);
        deleteUser(user_id_delete);
    });

    //Evenement pour fermer la fenêtre modale si l'utilisateur clique sur annuler
    document.getElementById('cancelButtonDelete').addEventListener('click', function(event) {
        var modal = document.getElementById('deleteModal');
        modal.style.display = "none";
    });

    // Fonction pour ouvrir la fenêtre modale
    function openDeleteModal(userId) {
        document.getElementById('deleteModal').style.display = 'block';
        user_id_delete=userId;
        console.log(user_id_delete)
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    window.addEventListener('message', function(event) {
        console.log("Message reçu :", event);
        if (event.data.type === 'deleteUserModal') {
            console.log("Bonjour", event.data.userId);
            user_id_delete=event.data.userId;
            openDeleteModal(event.data.userId);
        } else {
            console.log("Type d'événement non pris en charge :", event.data.type);
        }
    });


</script>
</body>
</html>