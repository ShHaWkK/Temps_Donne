<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once('./addServiceModalWindow.php');
?>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
    <title>Espace Administrateur - Services</title>
</head>

<body>
<h2 style="text-align: center;">Gestion des services</h2>
<center>
    <div class="main-container-tabs">
        <div class="line">
            <button class="popup-button" id="openAddServiceButton">Ajouter un service</button>
            <script>
                document.getElementById('openAddServiceButton').addEventListener('click', function() {
                    console.log("click");
                    window.parent.postMessage('openAddServiceModal', '*');
                });
            </script>


            <button class="popup-button" href="./addServiceType.php" id="openAddServiceTypeButton"> Ajouter un type de service</button>
            <script>
                document.getElementById('openAddServiceTypeButton').addEventListener('click', function() {
                    window.location.href = 'addServiceType.php';
                });
            </script>

            <button class="popup-button" id="openAssignUserModalButton"> Affecter un utilisateur au service</button>

            <script>
                document.getElementById('openAssignUserModalButton').addEventListener('click', function() {
                    window.parent.postMessage('openAddTypeModalButton', '*');
                });
            </script>
        </div>

        <table id="serviceTable">
        </table>
    </div>
</center>

<!-- Fenêtre modale pour ajouter un type de service -->
<div id="typeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Ajouter un type de service</h2>
        <form id="typeForm">
            <label for="typeName">Nom :</label>
            <input type="text" id="typeName" name="typeName">
            <label for="typeDescription">Description :</label>
            <textarea id="typeDescription" name="typeDescription"></textarea>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</div>

<script src="js/services.js" defer></script>
<script src="./js/serviceType.js"></script>
</body>
</html>