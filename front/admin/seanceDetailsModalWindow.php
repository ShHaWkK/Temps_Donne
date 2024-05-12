<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Structure de la fenêtre modale -->
<div id="seance-Modal" class="modal">
    <div class="modal-content">
        <span class="close-seance-Details">&times;</span>
        <div id="seanceDetails"></div> <!-- Contenu des détails de la séance -->
        <div id="salleDetails"></div> <!-- Contenu des détails de la salle -->
    </div>
</div>

<script>
    // Fonction pour ouvrir la fenêtre modale lorsqu'on clique sur le bouton "Voir"
    document.querySelectorAll('.seanceDetails').forEach(button => {
        button.addEventListener('click', async function() {
            // Récupérer l'ID de la séance associée à ce bouton
            const seanceId = button.closest('tr').querySelector('input[name="id_buttons"]').value;

            // Récupérer les détails de la séance
            const seanceDetailsResponse = await fetch(`http://localhost:8082/index.php/seances/${seanceId}`);
            const seanceDetails = await seanceDetailsResponse.json();

            // Récupérer les détails de la salle associée à la séance
            const salleDetailsResponse = await fetch(`http://localhost:8082/index.php/salles/${seanceDetails.ID_Salle}`);
            const salleDetails = await salleDetailsResponse.json();

            // Afficher les détails de la séance dans la fenêtre modale
            const seanceDetailsContainer = document.getElementById('seanceDetails');
            seanceDetailsContainer.innerHTML =
                `<h2>Détails de la séance</h2>
                <p>Description: ${seanceDetails.Description}</p>
                <p>Date: ${seanceDetails.Date}</p>
                <p>Heure de début: ${seanceDetails.Heure_Debut_Seance}</p>
                <p>Heure de fin: ${seanceDetails.Heure_Fin_Seance}</p>`;

            // Afficher les détails de la salle associée à la séance dans la fenêtre modale
            const salleDetailsContainer = document.getElementById('salleDetails');
            salleDetailsContainer.innerHTML =
                `<h2>Détails de la salle</h2>
                <p>Numéro: ${salleDetails.Numero}</p>
                <p>Adresse: ${salleDetails.Adresse}</p>`;

            // Afficher la fenêtre modale
            const modal = document.getElementById('seance-Modal');
            modal.style.display = 'block';
        });
    });

    // Fermer la fenêtre modale lorsqu'on clique sur la croix
    document.querySelector('.close-seance-Details').addEventListener('click', function() {
        const modal = document.getElementById('seance-Modal');
        modal.style.display = 'none';
    });

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('seance-Modal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>

</body>
</html>