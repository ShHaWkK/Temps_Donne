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
        <span class="close" id="close-delete">&times;</span>
        <h2>Suppression</h2>
        <p>Voulez-vous retirer ce stock de l'entrepot ? Cette action est irréversible</p>
        <div>
            <button class="confirm-button" id="confirmButtonDelete">Confirmer</button>
            <button class="cancel-button" id="cancelButtonDelete">Annuler</button>
        </div>
    </div>
</div>

<div id="deleteExpiredModal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-delete-expired">&times;</span>
        <h2>Suppression</h2>
        <p>Voulez-vous retirer tous les stocks périmés de l'entrepot ? Cette action est irréversible</p>
        <div>
            <button class="confirm-button" id="confirmButtonDeleteExpired">Confirmer</button>
            <button class="cancel-button" id="cancelButtonDeleteExpired">Annuler</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirmButtonDelete').addEventListener('click', function(event) {
        deleteStock();
    });

    document.getElementById('confirmButtonDeleteExpired').addEventListener('click', function(event) {
        deleteExpiredStocks(displayedStocks);
    });

    //Evenement pour fermer la fenêtre modale si l'utilisateur clique sur annuler
    document.getElementById('cancelButtonDelete').addEventListener('click', function(event) {
        var modal = document.getElementById('deleteModal');
        modal.style.display = "none";
    });
    document.getElementById('cancelButtonDeleteExpired').addEventListener('click', function(event) {
        var modal = document.getElementById('deleteExpiredModal');
        modal.style.display = "none";
    });

    // Fonction pour ouvrir la fenêtre modale
    function openDeleteStockModal() {
        document.getElementById('deleteModal').style.display = 'block';
    }
    function openDeleteExpiredStockModal() {
        document.getElementById('deleteExpiredModal').style.display = 'block';
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
    window.onclick = function(event) {
        var modal = document.getElementById('deleteExpiredModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

        // Fermer la fenêtre modale lorsqu'on clique sur la croix
    document.getElementById('close-delete').addEventListener('click', function() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
    });
    document.getElementById('close-delete-expired').addEventListener('click', function() {
        const modal = document.getElementById('deleteExpiredModal');
        modal.style.display = 'none';
    });
</script>
</body>
</html>