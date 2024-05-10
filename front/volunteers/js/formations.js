function addFormationDetailsListeners(){
    console.log("On est là");
    document.querySelectorAll('.service-button').forEach(button => {
        console.log(button);
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
                '<p><h3>Date de début: </h3>' + formationDetails.dateFormation + '</p>' +
                '<p><h3>Date de fin: </h3>' + formationDetails.duree + '</p>';

            // Afficher la fenêtre modale
            const modal = document.getElementById('formationDetailsModal');
            modal.style.display = 'block';
        });
    });
}