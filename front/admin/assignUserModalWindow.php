<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>
<center>
    <div id="assignModal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-assign">&times;</span>
            <h2>Assignation utilisateur(s)</h2>

            <table id="usersTable">
            </table><br><br>

            <button class="confirm-button" id="confirmButtonAssign">Confirmer</button>
            <button class="-cancel-button" id="cancelButtonAssign">Annuler</button>

        </div>
    </div>
</center>


<script>
    let service_id_assign;

    document.getElementById('confirmButtonAssign').addEventListener('click', function(event) {
        // Sélectionner tous les éléments input de type checkbox qui sont cochés
        const checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');

        // Initialiser un tableau pour stocker les valeurs des cases cochées
        const selectedUsers = [];

        // Parcourir les éléments cochés et extraire leurs valeurs
        checkedCheckboxes.forEach(checkbox => {
            selectedUsers.push(checkbox.value);
        });
        console.log("Valeurs des cases cochées :", selectedUsers);

        assignUsers(selectedUsers,service_id_assign);
    });

    //Evenement pour fermer la fenêtre modale si l'utilisateur clique sur annuler
    document.getElementById('cancelButtonAssign').addEventListener('click', function(event) {
        var modal = document.getElementById('deleteModal');
        modal.style.display = "none";
    });

    // Fonction pour ouvrir la fenêtre modale
    function openAssignUserModal(serviceId,role) {
        document.getElementById('assignModal').style.display = 'block';
        console.log("service_id_assign previous",service_id_assign)
        console.log("serviceId",serviceId);
        service_id_assign=serviceId;
        console.log("service_id_assign",service_id_assign);

        console.log("role",role);

        if(role === 'beneficiary') {
            displayBeneficiaries();
        }
        else{
            displayVolunteers();
        }

    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('assignModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    document.getElementById('close-assign').addEventListener('click', function() {
        const modal = document.getElementById('assignModal');
        modal.style.display = 'none';
    });
</script>
</body>
</html>