<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
?>

<head>
    <link rel="stylesheet" href="./css/table.css"
    <link rel="stylesheet" href="../css/services.css">
    <script src="./js/checkSessionAdmin.js"></script>
    <title>Espace Administrateur - Ajouter type de service</title>
</head>

<body>
<div class="main-container">
    <h2>Type de services</h2>

    <line>
        <button class="popup-button" id="openAddServiceTypeModal">Ajouter un type de service</button>

        <script>
            document.getElementById('openAddUserModal').addEventListener('click', function() {
                window.parent.postMessage('openAddServiceTypeModal', '*');
            });
        </script>

        <button class="popup-button" id="openAddServiceTypeModal">Supprimer un type service</button>

        <script>
            document.getElementById('openAddUserModal').addEventListener('click', function() {
                window.parent.postMessage('openAddServiceTypeModal', '*');
            });
        </script>

    </line>


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
<!--                        <img src="../images/icones/${service.Nom_Type_Service.replace(/\s+/g, '-').toLowerCase()}.png" alt="${service.Nom_Type_Service}" width="100" height="100">-->
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
