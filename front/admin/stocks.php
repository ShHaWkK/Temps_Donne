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
        <div class="line">

                <label for="productFilter">Filtrer par produit :</label>
                <select id="productFilter" name="productFilter">
                    <option value="all">Tous</option>
                </select>

                <label for="entrepotFilter">Filtrer par entrepot :</label>
                <select id="entrepotFilter" name="entrepotFilter">
                    <option value="all">Tous</option>
                </select>

                <label for="statusFilter">Filtrer par statut :</label>
                <select id="statusFilter">
                    <option value="all">Tous</option>
                    <option value="en_stock">En stock</option>
                    <option value="en_route">En route</option>
                    <option value="retire">Retiré</option>
                </select>
        </div>

        <div class="line">
<!--
                <label for="productFilter">Trier par ID :</label>
                <select id="productFilter" name="productFilter">
                    <option value="all">Tous</option>
                </select>
-->
            <label for="receptionDateSort">Trier par date de réception :</label>
            <select id="receptionDateSort" name="Sort">
                <option value="DateReceptionAsc">Plus ancienne</option>
                <option value="DateReceptionDesc">Plus récente</option>
            </select>

            <label for="peremptionDateSort">Trier par date de péremption :</label>
            <select id="peremptionDateSort" name="Sort">
                <option value="DatePeremptionAsc">Plus ancienne</option>
                <option value="DatePeremptionDesc">Plus récente</option>
            </select>

        </div>

        <table id="stockTable">
        </table>
    </div>
</center>

<script src="./js/stocks.js"></script>
<script src="./js/filtersStock.js"></script>

</body>
</html>
