<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once('addUserModalWindow.php');
echo "<title>Espace Administrateur - Stocks</title>";
?>
<body>
<center>
<h1>Gestion des Stocks</h1>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<!-- Boutons pour les opérations CRUD -->
<div>
    <button onclick="showAddForm()">Ajouter un stock</button>
</div>
    
<!-- Formulaire pour ajouter un stock -->
<div id="addStockForm" style="display: none;">
    <h2>Ajouter un stock</h2>
    <form action="process.php" method="POST">
        <!-- Champs pour les détails du stock -->
        <!-- Par exemple: Entrepôt, Produit, Quantité, etc. -->
        <input type="text" name="entrepot" placeholder="Entrepôt"><br>
        <input type="text" name="produit" placeholder="Produit"><br>
        <input type="number" name="quantite" placeholder="Quantité"><br>
        <button type="submit">Ajouter</button>
    </form>
</div>

<!-- Liste des stocks -->
<div>
    <h2>Liste des Stocks</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Entrepôt</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
        <!-- Afficher les stocks récupérés depuis l'API -->
        <?php
        // Effectuer une requête HTTP vers l'API
        $url = 'http://localhost:8082/index.php/stocks/';
        $response = file_get_contents($url);
        $stocks = json_decode($response, true);

        foreach ($stocks as $stock) {
            echo "<tr>";
            echo "<td>".$stock['id']."</td>";
            echo "<td>".$stock['entrepot']."</td>";
            echo "<td>".$stock['produit']."</td>";
            echo "<td>".$stock['quantite']."</td>";
            echo "<td>";
            echo "<button onclick=\"editStock(".$stock['id'].")\">Modifier</button>";
            echo "<button onclick=\"deleteStock(".$stock['id'].")\">Supprimer</button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</center>
<!-- Script JavaScript pour les interactions avec la page -->
<script>
    function showAddForm() {
        var form = document.getElementById('addStockForm');
        form.style.display = 'block';
    }

    function editStock(id) {
        // Logique pour éditer un stock
    }

    function deleteStock(id) {
        // Logique pour supprimer un stock
    }
</script>
</body>
</html>