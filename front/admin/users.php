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

<h1 style="text-align: center;">Gestion des utilisateurs</h1>

<center>
    <div class="main-container-tabs">
        <div class="line filters">
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

        <div class="line actions">
            <button class="popup-button" id="openAddUserModalButton"> Ajouter un utilisateur</button>
            <script>
                document.getElementById('openAddUserModalButton').addEventListener('click', function() {
                    window.parent.postMessage('openAddUserModal', '*');
                });
            </script>

            <button class="tabButton addButton" id="approveUser"> Valider un utilisateur</button>
            <script>
                document.getElementById('approveUser').addEventListener('click', function() {
                    approveUser(selectedUser);
                });
            </script>
            <button class="tabButton holdButton" id="holdUser"> Mettre un utilisateur en attente</button>
            <script>
                document.getElementById('holdUser').addEventListener('click', function() {
                    putOnHoldUser(selectedUser);
                });
            </script>
            <button class="tabButton deleteButton" id="rejectUser"> Refuser un utilisateur</button>
            <script>
                document.getElementById('rejectUser').addEventListener('click', function() {
                    rejectUser(selectedUser)
                        .then(() => {
                            openDeleteModal();
                        })
                });
            </script>

        </div>

        <table id="usersTable">
        </table>
    </div>
</center>

<script src="../scripts/getCookie.js"></script>
<script src="js/filtersUsers.js"></script>
<script src="js/users.js"></script>
<script src="./js/approveUser.js"></script>
<script src="./js/putOnHoldUser.js"></script>
<script src="./js/rejectUser.js"></script>
<script src="./js/deleteUser.js"></script>
<script src="./js/userPageExecutionOrder.js"></script>

</body>
</html>