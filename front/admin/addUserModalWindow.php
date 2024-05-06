<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
    <title>Ajouter un utilisateur</title>
</head>
<body>

<!-- Fenêtre modale -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <h2>Ajouter un utilisateur</h2>
        <form id="userForm" action="#" method="post">

            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="Nom"><br><br>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="Prénom"><br><br>

            <label for="genre">Genre:</label>
            <select id="genre" name="genre">
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="example@gmail.com"><br><br>

            <label for="password">Mot de passe:</label>
            <input type="password" id="motDePasse" name="motDePasse" value="motdepasse123"><br><br>

            <label for="role">Rôle:</label>
            <select id="role" name="role">
                <option value="Benevole">Bénévole</option>
                <option value="Beneficiaire">Bénéficiaire</option>
                <option value="Administrateur">Administrateur</option>
            </select><br><br>

            <label for="status">Statut:</label>
            <select id="status" name="status">
                <option value="Granted">Validé</option>
                <option value="Pending">En attente</option>
            </select><br><br>

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" value="123 Rue Exemple"><br><br>

            <label for="telephone">Téléphone:</label>
            <input type="tel" id="telephone" name="telephone" value="0123456789"><br><br>

            <label for="dateNaissance">Date de naissance:</label>
            <input type="date" id="dateNaissance" name="dateNaissance" value="1990-01-01"><br><br>

            <label for="nationalite">Nationalité:</label>
            <input type="text" id="nationalite" name="nationalite" value="Française"><br><br>

            <label for="situation">Situation:</label>
            <input type="text" id="situation" name="situation" value="Etudiant"><br><br>

            <label for="emploi">Emploi:</label>
            <input type="text" id="emploi" name="emploi" value="Etudiant"><br><br>

            <label for="societe">Société:</label>
            <input type="text" id="societe" name="societe" value="Université Exemple"><br><br>

            <label for="typePermis">Type de permis:</label>
            <input type="text" id="typePermis" name="typePermis" value="B"><br><br>

            <input class="confirm-button" id="confirm-button" type="submit" value="Ajouter">
        </form>
    </div>
</div>

<script>
    // Fonction pour ouvrir la fenêtre modale
    function openModal() {
        document.getElementById('addUserModal').style.display = 'block';
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('addUserModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Écouter les messages envoyés par l'iframe parent
    window.addEventListener('message', function(event) {
        if (event.data === 'openAddUserModal') {
            openModal();
        }
    });
</script>

<script src="./js/addUser.js"></script>

</body>
</html>