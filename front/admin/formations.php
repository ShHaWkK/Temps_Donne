<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once('userDetailsModalWindow.php');
include_once('formationDetailsModalWindow.php');
echo "<title>Espace Administrateur - Formations</title>";
?>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>

<h1 style="text-align: center;">Formations</h1>

<center>
    <div class="main-container-tabs">
        <!-- Onglets permettant de basculer entre les sections  -->
        <div class="tabs">
            <button class="tab-link" onclick="openTab(event, 'inscriptionsTab')">Inscriptions</button>
            <button class="tab-link" onclick="openTab(event, 'formationTab')">Formations</button>
        </div>

        <div class="tab-section" id="inscriptionsTab">

            <h2>Gestions des inscriptions</h2>
            <div class="line filters">
                <form action="#" method="post">
                    <label for="statusFilter">Filtrer par statut :</label>
                    <select id="statusFilter">
                        <option value="all">Toutes</option>
                        <option value="Pending">En attente</option>
                        <option value="Granted">Validés</option>
                        <option value="Denied">Refusés</option>
                    </select>
                </form>
            </div>

            <div class="line actions">
                <button class="tabButton neutralButton" id="openAddInscriptionModalButton"> Ajouter une inscription</button>
                <button class="tabButton addButton approveInscription" id="approveInscription"> Valider une inscription </button>
                <button class="tabButton holdButton holdInscription" id="holdInscription"> Mettre une demande en attente</button>
                <button class="tabButton deleteButton rejectInscription" id="rejectInscription"> Refuser une inscription</button>
            </div>

            <table id="inscriptionTable">
            </table>
        </div>

        <div class="tab-section" id="formationTab">
            <h2>Gestions des formations</h2>

            <div class="line actions">
                <button class="tabButton addButton" id="openAddFormationModalButton"> Ajouter une formation </button>
                <button class="tabButton deleteButton" id="openDeleteFormationModalButton"> Supprimer une formation</button>
                <button class="tabButton neutralButton" id="openAddSessionModalButton"> Plannifier une séance</button>
            </div>

            <table id="formationTable">
            </table>
        </div>



</center>


<script>
    /*
    document.getElementById('approveUser').addEventListener('click', function() {
        approveInscription(selectedInscription);
    });

    document.getElementById('openAddUserModalButton').addEventListener('click', function() {
    });

    document.getElementById('holdUser').addEventListener('click', function() {
        putOnHoldInscription(selectedInscription);
    });

    document.getElementById('rejectUser').addEventListener('click', function() {
        rejectInscription(selectedUser)
            .then(() => {
                openDeleteModal();
            })


    });
       */
</script>
<script>
    // Par défaut, afficher le premier onglet
    document.getElementById("inscriptionsTab").style.display = "block";
</script>
<script src="../scripts/getCookie.js"></script>
<script src="./js/users.js"></script>
<script src="js/formations.js"></script>
<script src="./js/inscriptionsStatus.js"></script>
<script src="../scripts/tabChange.js"></script>
<script src="./js/formationExecutionOrder.js"></script>

</body>
</html>