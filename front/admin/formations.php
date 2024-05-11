<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
//include_once('addUserModalWindow.php');
//include_once('userDetailsModalWindow.php');
//include_once('deleteUserModalWindow.php');
echo "<title>Espace Administrateur - Formations</title>";
?>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>

<h1 style="text-align: center;">Gestion des formations</h1>

<center>
    <div class="main-container-tabs">
        <!-- Onglets permettant de basculer entre les sections  -->
        <div class="tabs">
            <button class="tab-link" onclick="openTab(event, 'inscriptionsTab')">Inscriptions</button>
            <button class="tab-link" onclick="openTab(event, 'formationTab')">Ajout des formations</button>
            <button class="tab-link" onclick="openTab(event, 'seancesTab')">Gestion des séances</button>
        </div>

        <div class="tab-section" id="inscriptionsTab">

            <h2>Gestions des inscriptions</h2>
            <div class="line filters">
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
                <button class="tabButton neutralButton" id="openAddUserModalButton"> Ajouter une inscription</button>
                <button class="tabButton addButton" id="approveUser"> Valider une demande </button>
                <button class="tabButton holdButton" id="holdUser"> Mettre une demande en attente</button>
                <button class="tabButton deleteButton" id="rejectUser"> Refuser une demande</button>
            </div>

            <table id="inscriptionTable">
            </table>
            <div>

        <div class="tab-section" id="formationTab"><div>

        <div class="tab-section" id="seancesTab"><div>

    </div>
</center>


<script>
    document.getElementById('approveUser').addEventListener('click', function() {
        // approveUser(selectedUser);
    });

    document.getElementById('openAddUserModalButton').addEventListener('click', function() {
        window.parent.postMessage('openAddUserModal', '*');
    });

    document.getElementById('holdUser').addEventListener('click', function() {
        // putOnHoldUser(selectedUser);
    });

    document.getElementById('rejectUser').addEventListener('click', function() {
        // rejectUser(selectedUser)
        //     .then(() => {
        //         openDeleteModal();
        //     })
    });
</script>
<script>
    // Par défaut, afficher le premier onglet
    document.getElementById("inscriptionsTab").style.display = "block";
</script>
<script src="../scripts/getCookie.js"></script>
<script src="js/filtersUsers.js"></script>
<script src="js/users.js"></script>
<script src="./js/approveUser.js"></script>
<script src="./js/putOnHoldUser.js"></script>
<script src="./js/rejectUser.js"></script>
<script src="./js/deleteUser.js"></script>
<script src="../scripts/tabChange.js"></script>
<!--<script src="./js/userPageExecutionOrder.js"></script>-->

</body>
</html>