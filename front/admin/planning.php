<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
include_once('addUserModalWindow.php');
echo "<title>Espace Administrateur - Services</title>";
?>

<head>
    <link rel="stylesheet" href="./css/users.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>

<h2 style="text-align: center;">Gestion des services</h2>

<center>
    <div class="main-container-users">
        <div class="line">

            <button class="popup-button  menu" id="openModalButton"> Ajouter un service</button>

            <script>
                document.getElementById('openModalButton').addEventListener('click', function() {
                    window.parent.postMessage('openModal', '*');
                });
            </script>

            <button class="popup-button  menu" id="openModalButton"> Ajouter un type de service</button>

            <script>
                document.getElementById('openModalButton').addEventListener('click', function() {
                    window.parent.postMessage('openModal', '*');
                });
            </script>

            <form action="#" method="post">
                <label for="roleFilter">Filtrer par service :</label>
                <select id="roleFilter">
                    <option value="all">Tous</option>

                </select>
            </form>

            <form action="#" method="post">
                <label for="statusFilter">Filtrer par date :</label>
                <select id="statusFilter">
                    <option value="recent">Plus récente</option>
                    <option value="ancient">Plus ancienne</option>

                </select>
            </form>
        </div>

        <table id="usersTable">
        </table>
    </div>
</center>

<script src="./js/filterByRole.js"></script>
<script src="./js/users.js" defer></script>
<script src="./js/approveUser.js"></script>
<script src="./js/rejectUser.js"></script>

</body>
</html>
