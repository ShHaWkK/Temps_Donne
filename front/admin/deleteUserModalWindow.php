<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de suppression</title>
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<div id="myModal" class="modal">
    <div class="modal-content">
        <h2>Confirmation de suppression</h2>
        <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
        <button class="confirm-button" id="confirmButton">Confirmer</button>
        <button class="cancel-button" id="cancelButton">Annuler</button>
    </div>
</div>

<script>
    // Récupérer le bouton qui ouvre la fenêtre modale
    var modal = document.getElementById('myModal');

    // Lien pour supprimer l'utilisateur
    var deleteLink = 'http://localhost:8082/index.php/users/';

    // Écouter les clics sur le bouton de confirmation
    document.getElementById('confirmButton').onclick = function() {
        // Envoyer la requête DELETE
        var userId = /* Remplacez ceci par l'ID de l'utilisateur */;
        fetch(deleteLink + userId, {
            method: 'DELETE'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La suppression de l\'utilisateur a échoué.');
                }
                alert('L\'utilisateur a été supprimé avec succès.');
                // Rafraîchir la page ou effectuer toute autre action nécessaire
            })
            .catch(error => {
                console.error('Erreur lors de la suppression de l\'utilisateur :', error.message);
                alert('Erreur lors de la suppression de l\'utilisateur :', error.message);
            });

        // Cacher la fenêtre modale après la confirmation
        modal.style.display = 'none';
    };

    // Écouter les clics sur le bouton d'annulation
    document.getElementById('cancelButton').onclick = function() {
        // Cacher la fenêtre modale en cas d'annulation
        modal.style.display = 'none';
    };

    document.getElementById('deleteButton').onclick = function() {
        modal.style.display = 'block';
    };
</script>

</body>
</html>
