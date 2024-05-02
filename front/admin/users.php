<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
echo "<title>Espace Administrateur - Utilisateurs</title>";
?>

<head>
    <link rel="stylesheet" href="./css/users.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>

<h2 style="text-align: center;">Gestion des utilisateurs</h2>

<div class="main-container-users">
    <form action="#" method="post">
        <label for="roleFilter">Filtrer par rôle :</label>
        <select id="roleFilter">
            <option value="all">Tous</option>
            <option value="Benevole">Bénévoles</option>
            <option value="Beneficiaire">Bénéficiaires</option>
            <option value="Administrateur">Administrateurs</option>
        </select>
    </form>

    <table id="usersTable">
    </table>
</div>

<script src="./js/filterByRole.js"></script>
<script src="./js/users.js" defer></script>
<script src="./js/approveUser.js"></script>


</body>
</html>