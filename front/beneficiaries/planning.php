<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
echo "<title>Espace bénéficiaire - Planning</title>";
include_once ('../planning.php');
?>
<script src="./js/checkSessionBeneficiaries.js"></script>
<script src="../scripts/planning.js"> </script>
<script src="../scripts/getCookie.js"></script>