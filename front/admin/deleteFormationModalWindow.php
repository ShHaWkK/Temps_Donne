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

    async function deleteFormation(formation_id) {
        const apiUrl = 'http://localhost:8082/index.php/services/' + service_id;
        const options = {
            method: 'DELETE'
        };

        try {
            const response = await fetch(apiUrl, options);
            if (!response.ok) {
                throw new Error('Erreur lors de la requête');
            }

            const data = await response.json();
            console.log('Réponse du serveur:', data);
            alert(JSON.stringify(data));
            // Recharger la page après l'approbation de l'utilisateur
            window.location.reload();
        } catch (error) {
            console.error('Error :', error);
            alert('Error : ',error);
            // Recharger la page en cas d'erreur
            window.location.reload();
        }
    }
</script>
</body>
</html>