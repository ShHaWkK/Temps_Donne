<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Structure de la fenêtre modale -->
<div id="formationDetailsModal" class="modal">
    <div class="modal-content">
        <span id="close-formation-details" class="close">&times;</span>
        <div id="formationDetails"></div>
<!--        <button class="confirm-button" id="formationInscription">S'inscrire</button>-->
    </div>
</div>

<script>
    // Fermer la fenêtre modale lorsqu'on clique sur la croix
    document.getElementById('close-formation-details').addEventListener('click', function() {
        const modal = document.getElementById('formationDetailsModal');
        modal.style.display = 'none';
    });

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('formationDetailsModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    function addFormationDetailsListeners(){
        console.log("On est dans addFormationDetailsListeners");
        document.querySelectorAll('.formationsDetails').forEach(button => {
            button.addEventListener('click', async function() {
                // Récupérer l'ID de la formation associée à ce bouton
                const formationId = button.id;
                console.log("formationId",formationId);

                // Récupérer les détails de la formation
                const formationDetailsResponse = await fetch(`http://localhost:8082/index.php/formations/${formationId}`);
                const formationDetails = await formationDetailsResponse.json();
                console.log(formationDetails);

                // Afficher les détails de la formation dans la fenêtre modale
                const formationDetailsContainer = document.getElementById('formationDetails');
                formationDetailsContainer.innerHTML =
                    '<h2>Détails de la formation</h2>' +
                    // '<p><h3>ID Formation: </h3>' + formationDetails.id + '</p>' +
                    '<p><h3>Titre: </h3>' + formationDetails.titre + '</p>' +
                    '<p><h3>Description: </h3>' + formationDetails.description + '</p>' +
                    '<p><h3>Date de début: </h3>' + formationDetails.dateDebut + '</p>' +
                    '<p><h3>Date de fin: </h3>' + formationDetails.dateFin + '</p>';
                // '<p><h3>Organisateur: </h3>' + formationDetails.dateFin + '</p>';


                // Afficher la fenêtre modale
                const modal = document.getElementById('formationDetailsModal');
                modal.style.display = 'block';
            });
        });
    }

</script>

</body>
</html>