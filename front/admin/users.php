<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once('addUserModalWindow.php');
include_once('userDetailsModalWindow.php');
include_once('deleteUserModalWindow.php');
echo "<title>Espace Administrateur - Utilisateurs</title>";
?>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>

<h2 style="text-align: center;">Gestion des utilisateurs</h2>

<center>
    <div class="main-container-tabs">
        <div class="line">

            <button class="popup-button" id="openAddUserModalButton"> Ajouter un utilisateur</button>

            <script>
                document.getElementById('openAddUserModalButton').addEventListener('click', function() {
                    window.parent.postMessage('openAddUserModal', '*');
                });
            </script>

            <form action="#" method="post">
                <label for="roleFilter">Filtrer par rôle :</label>
                <select id="roleFilter">
                    <option value="all">Tous</option>
                    <option value="Benevole">Bénévoles</option>
                    <option value="Beneficiaire">Bénéficiaires</option>
                    <option value="Administrateur">Administrateurs</option>
                </select>
            </form>

            <form action="#" method="post">
                <label for="statusFilter">Filtrer par statut :</label>
                <select id="statusFilter">
                    <option value="all">Tous</option>
                    <option value="Pending">En attente</option>
                    <option value="Granted">Validés</option>
                    <option value="Denied">Refusés</option>
                </select>
            </form>
        </div>

        <table id="usersTable">
        </table>
    </div>
</center>

<script src="./js/filterByRole.js"></script>
<script src="js/users.js" defer></script>
<script src="./js/approveUser.js"></script>
<script src="./js/putOnHoldUser.js"></script>
<script src="./js/rejectUser.js"></script>
<script src="./js/deleteUser.js"></script>

</body>
</html>