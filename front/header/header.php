<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>

<header>
    <div class="header-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="../images/logo.png" alt="Logo Au Temps Donné" class="logo">
        </div>

        <!-- Boutons de navigation -->
        <nav class="navigation-menu">   
            <ul class="header-menu">
                <li><a href="index.php" class="nav-item active"><i class="fa fa-home"></i> Accueil</a></li>
                <li><a href="services.php" class="nav-item"><i class="fa-solid fa-users"></i> Services</a></li>
                <li><a href="dons.php" class="nav-item-space"><i class="fa-solid fa-hand-holding-dollar"></i> Faire un <br>don</a></li>
                <li><a href="espace_beneficiaire.php" class="nav-item-space"><i class="fa-solid fa-handshake"></i> Espace <br> bénéficiaire</a></li>
                <li><a href="espace_benevole.php" class="nav-item-space"> <i class='fa-solid fa-hand-holding-heart'></i> Espace <br>bénévole</a></li>
            </ul>
        </nav>

        <div class="popover-container menu">
            <button class="popup-button" >
                <i class="fa-solid fa-bars"></i><i class="icon icon--md icon--caret-down"></i></i>
            </button>
            <ul class="popover-content" id="serviceList">
                <li>
                    <a href="index.php" class="nav-item active">
                        <i class="fa fa-home"></i> Accueil
                    </a>
                </li>
                <li>
                    <a href="services.php" class="nav-item">
                        <i class="fa-solid fa-users"></i> Services
                    </a>
                </li>
                <li>
                    <a href="dons.php" class="nav-item-space">
                        <i class="fa-solid fa-hand-holding-dollar"></i> Faire un don
                    </a>
                </li>
                <li>
                    <a href="espace_beneficiaire.php" class="nav-item-space">
                        <i class="fa-solid fa-handshake"></i> Espace bénéficiaire
                    </a>
                </li>
                <li>
                    <a href="espace_benevole.php" class="nav-item-space">
                        <i class="fa-solid fa-hand-holding-heart"></i> Espace bénévole
                    </a>
                </li>
            </ul>
        </div>


        <!-- Barre de recherche et icône de recherche -->
        <div class="search-container">
            <div class="search-icon">
                <input class="search-input" type="text" placeholder="Recherche..." id="searchInput">
                <a><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
        
        <form class="search-icon-mobile">
            <input type="text"
            placeholder="Search..">
                <i class="fa-solid fa-magnifying-glass"></i>
        </form>
        <script src="https://kit.fontawesome.com/a692e1c39f.js"
        crossorigin="anonymous"></script>

        <!-- Menu déroulant pour les langues -->
        <div class="popover-container">
            <button class="popup-button" onclick="toggleLanguageList()">
                <img src="../images/france.png" width="30" height="30">
                <i class="icon icon--md icon--caret-down"></i>
            </button>
            <ul class="popover-content" id="languageList">
                <li>
                    <a class="active track" >
                        <span class="text__general--heading">Français</span>
                    </a>
                </li>
                <li>
                    <a class="track">
                        <span class="text__general--heading">English</span>
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

<script src="../scripts/darkmode.js"></script>