<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Personnel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<?php
    include_once('header.php');
?>
<main class="main-content">
    <h1 class="main-title">Bienvenue sur votre espace personnel</h1>
    <p class="main-text">Vous pouvez consulter vos disponibilités, votre planning, vos messages, vos formations et votre profil.</p>
    <p class="main-text">N'hésitez pas à nous contacter si vous avez des questions.</p>
</main>
<body>
    <!-- Carrousel -->
    <div class="carousel-container">

        <div class="carousel-slide" style="background-image: url('images/maraude.jpg');">
            <button class="carousel-control left">‹</button>
            <button class="carousel-control right">›</button>

            <div class="carousel-text-container">
                <p class="carousel-text">MARAUDE À SAINT QUENTIN</p>
                <button class="participate-btn">JE PARTICIPE</button>
            </div>
        </div>

        <div class="carousel-slide" style="background-image: url('images/aide.png');">
            <button class="carousel-control left">‹</button>
            <button class="carousel-control right">›</button>

            <div class="carousel-text-container">
                <p class="carousel-text">AIDE AUX PERSONNES ÂGÉES</p>
                <button class="participate-btn">JE PARTICIPE</button>
            </div>
    </div>
</body>
<script src="js/carousel.js"></script>
</body>
<?php
include_once('../includes/footer.php');
?>
</html>
