<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>
<center>
    <div id="formation-seances-Modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-seances-Modal">&times;</span>
            <h2>Séances</h2>

            <table id="seancesTable">
            </table><br><br>


        </div>
    </div>
</center>


<script>
    // Fonction pour ouvrir la fenêtre modale
    async function openFormationSeancesModal(formationId) {
        document.getElementById('formation-seances-Modal').style.display = 'block';
        await displaySeances(formationId);
    }

    async function displaySeances(formationId) {
        // Récupérer l'ID de la formation associée à ce bouton
        // const formationId = button.id;
        console.log("formationId", formationId);

        // Récupérer les détails de la prochaine séance associée à cette formation
        const nextSeanceResponse = await fetch(`http://localhost:8082/index.php/formations/formation-sessions/` + formationId);
        console.log("nextSeanceResponse", nextSeanceResponse);
        const nextSeance = await nextSeanceResponse.json();
        console.log(nextSeance);

        const nextSeanceContainer = document.getElementById('seancesTable');
        if (nextSeance) {
            nextSeanceContainer.innerHTML =
                '<p><h3>Date: </h3>' + nextSeance.Date + '</p>' +
                '<p><h3>Heure de début: </h3>' + nextSeance.Heure_Debut_Seance + '</p>' +
                '<p><h3>Heure de fin: </h3>' + nextSeance.Heure_Fin_Seance + '</p>';
        } else {
            nextSeanceContainer.innerHTML =
                '<h2>Prochaine séance</h2>' +
                '<p>Aucune séance planifiée pour le moment.</p>';
        }
    }



    function addFormationSeancesListeners() {
        console.log("On est dans addFormationSeancesListeners");
        document.querySelectorAll('.seanceDetails').forEach(button => {
            console.log(button);
            button.addEventListener('click', async function() {
                // Afficher la fenêtre modale
                const modal = document.getElementById('formationDetailsModal');
                modal.style.display = 'block';
            });
            console.log("Il n'y a pas de boutons");
        });
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('formation-seances-Modal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    document.getElementById('close-seances-Modal').addEventListener('click', function() {
        const modal = document.getElementById('formation-seances-Modal');
        modal.style.display = 'none';
    });
</script>
</body>
</html>
