<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./css/services.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Services</title>
</head>

<body>

<div id="header"></div>

    <div class="main-container shade">
        <h1>Services</h1>
        <div class="service-list">
            <button class="service-button">
                <h3>Distribution alimentaire</h3>
                <img src="../images/icones/meal.png" width="100" height="100">
            </button>
            <button class="service-button">
                <h3>Services administratifs</h3>
                <img src="../images/icones/budget.png" width="100" height="100">
            </button>
            <button class="service-button">
                <h3>Navettes pour rendez-vous éloignés</h3>
                <img src="../images/icones/shuttle.png" width="100" height="100">
            </button>
            <button class="service-button">
                <h3>Cours d'alphabétisation pour adultes</h3>
                <img src="../images/icones/readAdult.png" width="100" height="100">
            </button>
            <button class="service-button">
                <h3>Soutien scolaire pour enfant</h3>
                <img src="../images/icones/read.png" width="100" height="100">
            </button>
            <button class="service-button">
                <h3>Récolte de fonds</h3>
                <img src="../images/icones/donate.png" width="100" height="100">
            </button>
            <button class="service-button">
                <h3>Visite et activités avec personnes âgées</h3>
                <img src="../images/icones/couple.png" width="100" height="100">
            </button>
        </div>
    </div>
</body>

</html>

<script>
    var xhr = new XMLHttpRequest();

    xhr.open('GET', '../header/header.php', true);

    xhr.onload = function() {

        if (xhr.status === 200) {
            document.getElementById('header').innerHTML = xhr.responseText;

            includeDarkModeScript();
        }
    };

    xhr.send();

    function includeDarkModeScript() {
        var script = document.createElement('script');
        script.src = "../scripts/darkmode.js";
        document.body.appendChild(script);
    }
</script>