<?php
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/services.css">
    <title>Espace bénéficiaire, Demandes</title>
</head>

<body>

<div class="main-container">
    <h1>Faire une demande</h1>
    <h2>Sélectionner un type de service</h2>
    <button class="tabButton addButton" onclick="addDemand()">Faire une demande</button>
    <div id="service-list" class="service-list"></div>
</div>

<?php include_once('../includes/footer.php'); ?>

<script src="js/checkSessionBeneficiaries.js"></script>
<script src="js/demands.js"></script>
<script src="../scripts/getCookie.js"></script>

</body>
</html>