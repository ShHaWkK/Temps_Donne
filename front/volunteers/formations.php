<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
echo "<title>Espace bénévole - Formations</title>";
?>

<head>
    <link rel="stylesheet" href="./css/formations.css">
    <script src="../scripts/checkSession.js"></script>
</head>
<body>

<center>
    <h1>Catalogue de formations</h1>

    <main>
        <div class="formations-container" id="formations-container">
            <!-- Ajouter d'autres formations selon le besoin -->
        </div>
    </main>
</center>

<script src="./js/dipslayFomations.js"></script>
</body>
</html>