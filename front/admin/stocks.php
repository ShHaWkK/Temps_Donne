<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once('./addStockModalWindow.php');
include_once('./deleteStockModalWindow.php');
include_once ('./userDetailsModalWindow.php');
echo "<title>Espace Administrateur - Stocks</title>";
?>

<head>
<!--    <link rel="stylesheet" href="./css/table.css">-->
    <script src="./js/checkSessionAdmin.js"></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRnUwwESRTk-EVVhTJEwjWz3CpiRnhScQ&libraries=places&callback=initMap"></script>
</head>

<body>
<center>
    <div class="main-container-tabs">
        <!-- Onglets permettant de basculer entre les deux sections  -->
        <div class="tabs">
            <button class="tab-link" onclick="openTab(event, 'stockTab')">Gestion des Stocks</button>
            <button class="tab-link" onclick="openTab(event, 'collectionTab')">Collecte des Produits</button>
        </div>

        <!-- Onglet Gestion des Stocks -->
        <div class="tab-section" id="stockTab">
            <h1>Gestion des Stocks</h1>

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
                    <button class="tabButton deleteButton" id="deleteExpiredButton"> Retirer tous les stocks périmés </button>
                    <script>
                        document.getElementById('deleteExpiredButton').addEventListener('click', function() {
                            console.log("click");
                            openDeleteExpiredStockModal();
                        });
                    </script>
                </div>
            </div>

            <table id="stockTable">
            </table>
        </div>

        <!-- Onglet Collecte des Produits -->
        <div class="tab-section" id="collectionTab">
            <h1>Collecte des produits</h1>

            <div class="line">
                <label for="entrepotFilter"> <h2> Entrepôt :</h2></label>
                <select id="entrepotFilterCollecte" name="entrepotFilterCollecte">
                </select>
            </div>

            <div class="line">
                <label for="truckList"> <h2>Camion :</h2></label>
                <select id="truckList" name="truckList">
                </select>
            </div>

            <div class="line">
                <h2>Chauffeur :</h2>
            </div>
            <div class="line">
                <table class="driverTable" id="driverTable"></table>
            </div>

            <div class="line">
                <h2>Points de passage :</h2>
            </div>
            <div class="line">
                <div class="fixed-height-table">
                    <table id="commercantTable" ></table>
                </div>
            </div>

            <button class="tabButton addButton addCircuit" id="generateCircuitButton"> Générer le circuit </button>

            <script>
                document.getElementById('generateCircuitButton').addEventListener('click', async function () {
                    // Attend la résolution de la promesse retournée par generateWaypoints
                    let waypoints = await generateWaypoints(document.getElementById('commercantTable'));
                    console.log("waypoints:", waypoints);

                    afficherAdressesDansDiv(waypoints, 'circuit');

                    let selectedEntrepot = document.querySelector('select[name="entrepotFilterCollecte"]').value;
                    console.log("selectedEntrepot", selectedEntrepot);

                    let address = getEntrepotAddress(allEntrepots, selectedEntrepot);
                    console.log("address", address);

                    let request = generateRouteRequest(address, address, waypoints);
                    console.log("request",request);

                    let order = getWaypointsOrder(request);
                    console.log("order",order);

                    displayRouteOnMap(map, request);

                    document.getElementById('generateCircuitButton').classList.toggle('active');

                    // Attendre une seconde avant d'exécuter generatePDF()
                    setTimeout(() => {
                        generatePDF();
                    }, 500); // 1000 ms = 1 seconde
                });

                function afficherAdressesDansDiv(tableau, divId) {
                    const div = document.getElementById(divId);
                    if (!div) {
                        console.error("La div spécifiée n'existe pas.");
                        return;
                    }

                    let contenuDiv = '<h2>Ordre de passage :</h2>\n<ul>';

                    for (let i = 0; i < tableau.length; i++) {
                        const adresse = tableau[i].location;
                        contenuDiv += `\n<li>${adresse}</li>\n`;
                    }

                    contenuDiv += '</ul>';

                    div.innerHTML = contenuDiv;
                }
            </script>

            <div class="section" id="circuit"></div>

            <div id="map" style="height: 400px; width: 100%;"></div>


        </div>
    </div>
</center>

<script src="./js/filtersStock.js"></script>
<script src="./js/addStock.js"></script>
<script src="./js/deleteStocks.js"></script>
<script src="./js/map.js"></script>
<script src="./js/users.js"></script>
<script src="js/displayDrivers.js"></script>
<script src="../scripts/tabChange.js"></script>
<script src="./js/displayCommercants.js"></script>
<script src="./js/generatePDF.js"></script>
<script src="./js/stocks.js"></script>
<script src="./js/stockPageExecutionOrder.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
