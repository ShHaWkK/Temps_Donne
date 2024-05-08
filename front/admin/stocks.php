<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
echo "<title>Espace Administrateur - Stocks</title>";
?>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>
<center>
    <h2>Gestion des Stocks</h2>

    <div class="main-container-tabs">
        <line></line>

        <table id="stockTable">
        </table>
    </div>
</center>

<script src="./js/stocks.js"></script>

</body>
</html>
