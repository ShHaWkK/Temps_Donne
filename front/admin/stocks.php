<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once('./addStockModalWindow.php');
include_once('./deleteStockModalWindow.php');
echo "<title>Espace Administrateur - Stocks</title>";
?>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>
<center>
    <h1>Gestion des Stocks</h1>

    <div class="main-container-tabs">

        <h2 class="EntrepotName"></h2>
        <div class="progress" id="progress">
            <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="filters">
            <div class="line">
                <label for="productFilter">Filtrer par produit :</label>
                <select id="productFilter" name="productFilter">
                    <option value="all">Tous</option>
                </select>

                <label for="entrepotFilter">Filtrer par entrepôt :</label>
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
        </div>

        <div class="actions">
            <div class="line">
                <button class="tabButton addButton" id="addStockButton"> Ajouter un stock </button>
                <script>
                    document.getElementById('addStockButton').addEventListener('click', function() {
                        console.log("click");
                        openAddStockModal();
                    });
                </script>
                <button class="tabButton deleteButton" id="deleteStockButton"> Retirer un stock </button>
                <script>
                    document.getElementById('deleteStockButton').addEventListener('click', function() {
                        console.log("click");
                        openDeleteStockModal();
                    });
                </script>
                <button class="tabButton deleteButton"> Retirer tous les stocks périmés </button>
                <script>
                    document.getElementById('addStockButton').addEventListener('click', function() {
                        console.log("click");
                        openAddStockModal();
                    });
                </script>
            </div>
        </div>

        <table id="stockTable">
        </table>
    </div>
</center>

<script src="./js/stocks.js"></script>
<script src="./js/filtersStock.js"></script>
<script src="./js/addStock.js"></script>

</body>
</html>