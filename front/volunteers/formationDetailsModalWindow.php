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
        <button class="confirm-button" id="formationInscription">S'inscrire</button>
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
</script>

</body>
</html>