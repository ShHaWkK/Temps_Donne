<?php
ob_start(); // Commence la mise en tampon de sortie
include_once('../includes/head.php');
include_once('../includes/header.php');
include_once('../includes/lang.php');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/services.css">
    <title>Espace bénéficiaire, Deamndes</title>
</head>

<body>

<div class="main-container">
    <h1>Faire une demande</h1>
    <div id="service-list" class="service-list"></div>
</div>

<?php include_once('../includes/footer.php'); ?>

<script>
    // Faire une requête HTTP GET pour récupérer les données JSON des types de service
    fetch('http://localhost:8082/index.php/services/type')
        .then(response => response.json())
        .then(data => {
            const serviceList = document.getElementById('service-list');
            data.success.forEach(service => {
                const button = document.createElement('button');
                button.classList.add('service-button');
                button.innerHTML = `
                        <h3>${service.Nom_Type_Service}</h3>
                        <img src="../images/icones/${service.Nom_Type_Service.replace(/\s+/g, '-').toLowerCase()}.png" alt="${service.Nom_Type_Service}" width="100" height="100">
                    `;
                serviceList.appendChild(button);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des données JSON :', error));

    function includeDarkModeScript() {
        var script = document.createElement('script');
        script.src = "../scripts/darkmode.js";
        document.body.appendChild(script);
    }
    // Appel du script darkmode.js directement
    includeDarkModeScript();
</script>
</body>
</html>