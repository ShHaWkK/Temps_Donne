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
    <div class="main-container shade">
        <h1>Catalogue de formations</h1>

        <div class="service-list" id="formations-container">
            <!-- Ajouter d'autres formations selon le besoin -->
        </div>

</center>

<script src="./js/formationExecutionOrder.js"></script>
<script src="js/displayFormations.js"></script>
<script src="./js/formations.js"></script>

</body>
</html>