let selectedFormation = null;

function addFormationDetailsListeners(){
    document.querySelectorAll('.service-button.available-formations').forEach(button => {
        console.log(button);
        button.addEventListener('click', async function() {
            // Récupérer l'ID de la formation associée à ce bouton
            const formationId = button.id;
            selectedFormation = formationId;
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

async function addNextSessionsListeners() {
    console.log("addNextSessionsListeners");

    // Sélectionner tous les boutons avec la classe 'service-button.my-formations'
    document.querySelectorAll('.service-button.my-formations').forEach(button => {
        console.log(button);
        button.addEventListener('click', async function() {
            // Désactiver tous les boutons ayant la classe active
            document.querySelectorAll('.service-button.my-formations').forEach(btn => {
                btn.classList.remove('active');
            });

            // Ajouter la classe active uniquement au bouton cliqué
            button.classList.add('active');

            // Récupérer l'ID de la formation associée à ce bouton
            const formationId = button.id;
            selectedFormation = formationId;

            const nextSessionsContainer = document.getElementById('nextSessions');
            nextSessionsContainer.innerHTML = '';

            // Récupérer les détails de la formation
            const nextSessionsResponse = await fetch(`http://localhost:8082/index.php/formations/formation-sessions/${formationId}`);
            const nextSessions = await nextSessionsResponse.json();
            console.log(nextSessions);

            // Vérifier si des sessions sont disponibles
            if (Object.keys(nextSessions).length > 0) {
                // Construction de la chaîne HTML pour afficher les détails de chaque session
                let sessionDetailsHTML = '<h2>Prochaines séances </h2>';

                // Parcourir les sessions et ajouter les détails à la chaîne HTML
                for (const key in nextSessions) {
                    if (nextSessions.hasOwnProperty(key) && key !== 'ID_Seance' && key !== 'ID_Salle' && key !== 'ID_Formation') {
                        sessionDetailsHTML += '<p><strong>' + key + ':</strong> ' + nextSessions[key] + '</p>';
                    }
                }

                // Afficher les détails de toutes les sessions dans la div
                nextSessionsContainer.innerHTML = sessionDetailsHTML;
            } else {
                // Afficher un message si aucune session n'est disponible
                nextSessionsContainer.innerHTML = '<p>Aucune séance disponible pour cette formation.</p>';
            }
        });
    });
}