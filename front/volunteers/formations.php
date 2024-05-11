<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once ('./formationDetailsModalWindow.php');
echo "<title>Espace bénévole - Formations</title>";
?>

<head>
    <link rel="stylesheet" href="../css/services.css">
    <script src="js/checkSessionVolunteer.js"></script></head>
<body>

<center>
    <div class="main-container-tabs">
        <!-- Onglets permettant de basculer entre les deux sections  -->
        <div class="tabs">
            <button class="tab-link" onclick="openTab(event, 'availableFormationsTab')">Formations disponibles</button>
            <button class="tab-link" onclick="openTab(event, 'myFormationsTab')">Mes formations</button>
        </div>

        <!-- Onglet Formations disponibles -->
        <div class="tab-section" id="availableFormationsTab">
            <section>
                <h1>Formations disponibles</h1>

                <div class="service-list" id="available-formations">
                </div>
            </section>
        </div>

        <!-- Onglet Mes Formations -->
        <div class="tab-section" id="myFormationsTab">
            <h1> Mes formations </h1>
            <div class="scrollable-div" id="my-formations">
            </div>
<!--            <h2>Prochaines séances :</h2>-->
            <div id="nextSessions"></div>
        </div>
    </div>
</center>

<script>
    // Par défaut, afficher le premier onglet
    document.getElementById("availableFormationsTab").style.display = "block";
</script>
<script src="../scripts/tabChange.js"></script>
<script src="../scripts/getCookie.js"></script>
<script src="./js/inscriptionFormation.js"></script>
<script src="./js/formationExecutionOrder.js"></script>
<script src="./js/displayFormations.js"></script>
<script src="./js/formations.js"></script>

</body>
</html>