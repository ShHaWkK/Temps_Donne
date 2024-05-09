<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>

<header id="mainHeader">
    <div class="header-container">

        <button id="menuButton" class="popup-button  menu" >
            <i class="fa-solid fa-bars"></i></i>
            Menu
        </button>

        <!-- Barre de recherche et icône de recherche -->
        <div class="search-container">
            <div class="search-icon">
                <input class="search-input" type="text" placeholder="Recherche..." id="searchInput">
                <a><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>

        <!-- Boutons de navigation -->
        <nav class="navigation-menu">
            <ul class="header-menu">

                <button class="popup-button  menu" >
                    <i class="fa-solid fa-user"> </i>Profil
                </button>

                <button class="popup-button  menu" >
                    <i class="fa-solid fa-envelope"></i>Messages
                </button>

                <button class="popup-button  menu" >
                    <i class="fa-solid fa-bell"></i>Notifications
                </button>
            </ul>
        </nav>

        <!-- Menu déroulant pour les langues -->
        <div class="popover-container">
            <?php
            $imagePath = htmlspecialchars($data["FLAG"]);
            ?>
            <button class="popup-button" onclick="toggleLanguageList()">
                <img src="<?php echo $imagePath; ?>" width="30" height="30">
            </button>
            <ul class="popover-content" id="languageList">
                <li>
                    <a href="javascript:void(0);" onclick="changeLanguage('fr')">
                        <span class="text__general--heading"><?php echo htmlspecialchars($data["FRENCH"]) ?></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" onclick="changeLanguage('en')">
                        <span class="text__general--heading"><?php echo htmlspecialchars($data["ENGLISH"] ); ?></span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Bouton de mode sombre -->
        <div class="dark-mode-toggle">
            <label class="switch darkmode">
                <input type="checkbox" id="darkModeToggle">
                <span class="slider round dark"></span>
            </label>
        </div>
    </div>
</header>

<aside class="sidebar bebas-neue">
    <div class="profile-section">
        <img src="../../images/Ethan.jpg" alt="Photo de profil">
        <h2>Nom et Prénom</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="./panel_volunteer.php" class="nav-item active"><i class="fa fa-home"></i>Accueil</a>
        <a href="./users.php" class="nav-item"><i class="fa fa-calendar-check"></i>Utilisateurs</a>
        <a href="./services.php" class="nav-item"><i class="fa fa-calendar-alt"></i>Services</a>
        <a href="./stocks.php" class="nav-item"><i class="fa fa-envelope"></i>Stocks</a>
        <a href="#" class="nav-item"><i class="fa fa-graduation-cap"></i>Maraudes</a>
        <a href="#" class="nav-item"><i class="fa fa-user"></i>Profil</a>
    </nav>
    <div class="sidebar-footer">
        <a href="#" class="nav-item"><i class="fa fa-sign-out-alt"></i>Déconnexion</a>
    </div>
</aside>

<script>
    const menuButton = document.getElementById('menuButton');
    const sidebar = document.querySelector('.sidebar');
    const mainHeader = document.getElementById('mainHeader');

    menuButton.addEventListener('click', function() {
        sidebar.classList.toggle('sidebar-visible');
        mainHeader.classList.toggle('sidebar-visible');
        menuButton.classList.toggle('sidebar-visible');
    });
</script>
<script src="../scripts/darkmode.js"></script>
