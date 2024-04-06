<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Consentement</title>
    <link rel="stylesheet" href="../css/cookie.css">
</head>
<body>

    <div class="cookie-wrapper">
        <div class="titre">
            <i class="bx bx-cookie"></i>
            <img src="images/cookie.png" alt="Icookie" class="header-image">
            <h2>Cookies</h2>
        </div>
        <div class="data">
            <p>Lorsque vous visitez notre site, nous pouvons accéder à certaines de vos informations pour mieux vous aiguiller et faciliter la tâche sur notre site. Pour en savoir plus : <a href="#">Politique de confidentialité</a></p>
        </div>
        <div class="choisir">
            <button class="choix" id="acceptBtn">Accepter</button>
            <button class="choix" id="declineBtn">Refuser</button>
        </div>
    </div>

    <script>
    const cookieBox = document.querySelector(".cookie-wrapper"),
          buttons = document.querySelectorAll(".choix");

    const executeCodes = () => {
        if (document.cookie.includes("AuTempsDonnee")) return;
        cookieBox.classList.add("show");

        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                cookieBox.classList.remove("show");

                if (button.id == "acceptBtn") {
                    // Définit le cookie pour 1 mois
                    //document.cookie = "cookieBy=AuTempsDonnee; max-age=" + 60 * 60 * 24 * 30;
                    document.cookie = "cookieBy=AuTempsDonnee; max-age=" + 1;
                }
            });
        });
    };
    window.addEventListener("load", executeCodes);
</script>


</body>
</html>
