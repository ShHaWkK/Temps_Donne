<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-delete-formation">&times;</span>
        <h2>Suppression</h2>
        <p>Voulez-vous supprimer cette formation ?</p>
        <div>
            <button class="confirm-button" id="confirmButtonDelete">Confirmer</button>
            <button class="cancel-button" id="cancelButtonDelete">Annuler</button>
        </div>
    </div>
</div>

<script>
    let formation_id_delete;
    document.getElementById('confirmButtonDelete').addEventListener('click', function(event) {
        console.log(formation_id_delete);
        deleteFormation(formation_id_delete);
    });

    //Evenement pour fermer la fenêtre modale si l'utilisateur clique sur annuler
    document.getElementById('cancelButtonDelete').addEventListener('click', function(event) {
        var modal = document.getElementById('deleteModal');
        modal.style.display = "none";
    });

    // Fonction pour ouvrir la fenêtre modale
    function openDeleteFormationModal(formationId) {
        document.getElementById('deleteModal').style.display = 'block';
        formation_id_delete=formationId;
        console.log("formation id",formation_id_delete)
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Fermer la fenêtre modale lorsqu'on clique sur la croix
    document.getElementById('close-delete-formation').addEventListener('click', function() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
    });
</script>
</body>
</html>