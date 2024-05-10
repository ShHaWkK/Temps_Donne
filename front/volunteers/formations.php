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
        <div class="formations-container">
            <section class="formation">
                <h2>Formation 1</h2>
                <p>Description de la formation 1.</p>
                <button class="btn-inscription">S'inscrire</button>
            </section>
            <section class="formation">
                <h2>Formation 2</h2>
                <p>Description de la formation 2.</p>
                <button class="btn-inscription">S'inscrire</button>
            </section>
            <section class="formation">
                <h2>Formation 2</h2>
                <p>Description de la formation 2.</p>
                <button class="btn-inscription">S'inscrire</button>
            </section>
            <section class="formation">
                <h2>Formation 2</h2>
                <p>Description de la formation 2.</p>
                <button class="btn-inscription">S'inscrire</button>
            </section>
            <section class="formation">
                <h2>Formation 2</h2>
                <p>Description de la formation 2.</p>
                <button class="btn-inscription">S'inscrire</button>
            </section>
            <section class="formation">
                <h2>Formation 2</h2>
                <p>Description de la formation 2.</p>
                <button class="btn-inscription">S'inscrire</button>
            </section>
            <!-- Ajouter d'autres formations selon le besoin -->
        </div>
    </main>
</center>

</body>
</html>