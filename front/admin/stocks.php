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

            <form action="#" method="post">
                <label for="productFilter">Filtrer par produit :</label>
                <select id="productFilter" name="productFilter">
                    <option value="all">Tous</option>
                </select>
            </form>

            <form action="#" method="post">
                <label for="entrepotFilter">Filtrer par entrepot :</label>
                <select id="entrepotFilter" name="entrepotFilter">
                    <option value="all">Tous</option>
                </select>
            </form>

            <form action="#" method="post">
                <label for="statusFilter">Filtrer par statut :</label>
                <select id="statusFilter">
                    <option value="all">Tous</option>
                    <option value="en_stock">En stock</option>
                    <option value="en_route">En route</option>
                    <option value="retire">Retiré</option>
                </select>
            </form>
        </div>

        <table id="stockTable">
        </table>
    </div>
</center>

<script src="./js/stocks.js"></script>
<script src="./js/filtersStock.js"></script>

</body>
</html>
