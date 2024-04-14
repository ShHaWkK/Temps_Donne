<?php include_once('lang.php'); ?>
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
                <li><a href="../index.php" class="nav-item active"><i class="fa fa-home"></i> <?php echo htmlspecialchars($data["HOME"]); ?></a></li>
                <li><a href="../services/services.php" class="nav-item"><i class="fa-solid fa-users"></i> <?php echo htmlspecialchars($data["SERVICES"]); ?></a></li>
                <li><a href="../form/donations.php" class="nav-item"><i class="fa-solid fa-hand-holding-dollar"></i> <?php echo htmlspecialchars($data["MAKE_DONATION"]); ?></a></li>
                <li><a href="../inscription_conn/connexion_beneficiaire.php" class="nav-item"><i class="fa-solid fa-handshake"></i> <?php echo htmlspecialchars($data["BENEFICIARY_SPACE"]); ?></a></li>
                <li><a href="../inscription_conn/connexion_benevole.php" class="nav-item"> <i class='fa-solid fa-hand-holding-heart'></i> <?php echo htmlspecialchars($data["VOLUNTEER_SPACE"]); ?></a></li>
            </ul>
        </nav>

        <!-- Menu de navigation hamburger pour les modes mobiles et tablette -->
        <div class="popover-container menu">
            <button class="popup-button">
                <i class="fa-solid fa-bars"></i><i class="icon icon--md icon--caret-down"></i>
            </button>
            <ul class="popover-content" id="serviceList">
                <li>
                    <a href="index.php" class="nav-item active">
                        <i class="fa fa-home"></i> <?php echo htmlspecialchars($data["HOME"]); ?>
                    </a>
                </li>
                <li>
                    <a href="../services/services.php" class="nav-item">
                        <i class="fa-solid fa-users"></i> <?php echo htmlspecialchars($data["SERVICES"]); ?>
                    </a>
                </li>
                <li>
                    <a href="../form/dons.php" class="nav-item-space">
                        <i class="fa-solid fa-hand-holding-dollar"></i> <?php echo htmlspecialchars($data["MAKE_DONATION"]); ?>
                    </a>
                </li>
                <li>
                    <a href="espace_beneficiaire.php" class="nav-item-space">
                        <i class="fa-solid fa-handshake"></i> <?php echo htmlspecialchars($data["BENEFICIARY_SPACE"]); ?>
                    </a>
                </li>
                <li>
                    <a href="espace_benevole.php" class="nav-item-space">
                        <i class="fa-solid fa-hand-holding-heart"></i> <?php echo htmlspecialchars($data["VOLUNTEER_SPACE"]); ?>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Search bar -->
        <div class="search-container">
            <div class="search-icon">
                <input class="search-input" type="text" placeholder="<?php echo htmlspecialchars($data["SEARCH_PLACEHOLDER"] ?? 'Search...'); ?>" id="searchInput">
                <a><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>

        <!-- Mobile search icon -->
        <form class="search-icon-mobile">
            <input type="text" placeholder="<?php echo htmlspecialchars($data["SEARCH_PLACEHOLDER_MOBILE"] ?? 'Search...'); ?>">
            <i class="fa-solid fa-magnifying-glass"></i>
        </form>

        <script src="https://kit.fontawesome.com/a692e1c39f.js" crossorigin="anonymous"></script>

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

<script src="../scripts/darkmode.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Sélectionnez tous les éléments de navigation
        var navItems = document.querySelectorAll('.navigation-menu .nav-item');

        // Parcourez chaque élément de navigation
        navItems.forEach(function(navItem) {
            // Ajoutez un écouteur d'événements clic à chaque élément de navigation
            navItem.addEventListener('click', function(event) {
                // Supprimez la classe "active" de tous les éléments de navigation
                navItems.forEach(function(item) {
                    item.classList.remove('active');
                });

                // Ajoutez la classe "active" à l'élément de navigation cliqué
                navItem.classList.add('active');
            });
        });
    });

</script>