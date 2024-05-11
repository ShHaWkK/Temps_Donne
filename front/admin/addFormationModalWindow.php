<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body>

<div id="addFormationModal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-add-formation">&times;</span>
        <h2>Ajouter une formation</h2>
        <form id="formationForm" action="#" method="post">

            <label for="formationName">Titre de la formation :</label>
            <input type="text" id="formationName" name="formationName"  value="Formation" required><br><br>

            <label for="formationDescription">Description :</label>
            <textarea id="formationDescription" name="formationDescription" content="Formation" required></textarea><br><br>

            <label for="startDate">Date de début:</label>
            <input type="date" id="startDate" name="startDate" value="12-09-2024" required><br><br>

            <label for="endDate">Date de fin:</label>
            <input type="date" id="endDate" name="endDate" value="12-12-2024" required><br><br>

            <label for="usersTable">Organisateur:</label>
            <table id="usersTable">
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        fetch('http://localhost:8082/index.php/volunteers/All')
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Erreur lors de la récupération des données');
                                }
                                return response.json();
                            })
                            .then(users => {
                                console.log(users); // Affiche les données JSON récupérées
                                displayUsersInFormationModalWindow(users); // Passe les données JSON en tant que paramètre à votre fonction
                            })
                            .catch(error => {
                                console.error('Une erreur s\'est produite :', error);
                            });

                    });
                </script>
            </table><br><br>

            <input class="confirm-button" id="confirm-button-addFormation" type="submit" value="Ajouter">
        </form>
    </div>
</div>

<script>
    console.log("On est dans addFormationModal");

    // Fonction pour ouvrir la fenêtre modale
    function openAddFormationModal() {
        document.getElementById('addFormationModal').style.display = 'block';
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('addFormationModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Ajouter un écouteur d'événement sur la soumission du formulaire
    document.getElementById('formationForm').addEventListener('submit', function(event) {
        var startDate = new Date(document.getElementById('startDate').value + ' ' + document.getElementById('startDate').value);
        var endDate = new Date(document.getElementById('endDate').value + ' ' + document.getElementById('endDate').value);

        // Vérifier si la date de fin est postérieure à la date de début
        if (endDate <= startDate) {
            alert('La date de fin doit être ultérieure à la date de début.');
            event.preventDefault(); // Empêcher l'envoi du formulaire si la validation échoue
        }
        addFormation();
    });

    // Écouter les messages envoyés par l'iframe parent
    window.addEventListener('message', function(event) {
        if (event.data === 'openAddFormationModal') {
            openAddFormationModal();
        }
    });

    document.getElementById('close-add-formation').addEventListener('click', function() {
        const modal = document.getElementById('addFormationModal');
        modal.style.display = 'none';
    });

    function addFormation() {
        var apiUrl = 'http://localhost:8082/index.php/formations/create';

        // Récupérer les valeurs des champs du formulaire
        var titre = document.getElementById('formationName').value;
        var description = document.getElementById('formationDescription').value;
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;
        var id_organisateur = document.querySelector('input[name="id_buttons_user_formation"]:checked').value;

        // Créer un objet JSON avec les données du formulaire
        const data = {
            "Titre": titre,
            "Description": description,
            "Date_Debut_Formation": startDate,
            "Date_Fin_Formation": endDate,
            "ID_Organisateur": id_organisateur,
        };

        // Options de la requête HTTP
        var options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data),
            timeout: 10000
        };

        console.log(options);
        console.log(data);

        fetch(apiUrl, options)
            .then(response => {
                if (!response.ok) {
                    return response.text().then(errorMessage => {
                        throw new Error(errorMessage || 'Erreur inattendue.');
                    });
                }
                return response.json(); // Analyser la réponse JSON
            })
            .then(data => {
                alert(JSON.stringify(data));
            })
            .catch(error => {
                console.error('Erreur lors de la réponse de l\'API :', error.message);
                alert("failed to fetch");
            });
    }

    function displayUsersInFormationModalWindow(users){
        //On vérifie si le paramètre est valide
        if (!Array.isArray(users)) {
            console.error("Le paramètre 'users' doit être un tableau.");
            return;
        }

        const usersTable = document.getElementById('usersTable');

        usersTable.innerHTML = '';

        // On ajoute l'en-tête du tableau
        const tableHeader = ["", "Nom", "Prénom", "Genre"];

        const rowHeader = usersTable.insertRow();
        rowHeader.classList.add("head");

        for (let i = 0; i < tableHeader.length; i++) {
            const th = document.createElement("th");
            th.textContent = tableHeader[i];
            rowHeader.appendChild(th);
        }

        let firstUser = true;
        users.forEach(user => {
            const row = usersTable.insertRow();
            row.innerHTML = `
                        <td> <input type="radio" id=${user.ID_Utilisateur} name='id_buttons_user_formation' value=${user.ID_Utilisateur} ${firstUser ? 'checked' : ''} /> </td>
                        <td>${user.Nom}</td>
                        <td>${user.Prenom}</td>
                        <td>${user.Genre}</td>
                    `;
            if (firstUser === true) {
                selectedUser = user.ID_Utilisateur;
            }
            firstUser = false;
        });
    }
</script>

</body>
</html>