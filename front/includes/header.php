<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/header.css">
</head>

<header>
    <div class="header-container">
        <div class="logo-container">
            <img src="./images/logo.png" alt="Logo Au Temps Donné" class="logo">
        </div>
        <div class="hamburger-menu" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
        </div>
        <nav class="navigation-menu">   
            <ul>
                <li><a href="index.php" class="nav-item active"><i class="fa fa-home"></i> Accueil</a></li>
                <li><a href="services.php" class="nav-item"><i class="fa-solid fa-users"></i> Services</a></li>
                <li><a href="dons.php" class="nav-item"><i class="fa-solid fa-hand-holding-dollar"></i> Faire un don</a></li>
                <li><a href="espace_beneficiaire.php" class="nav-item"><i class="fa-solid fa-handshake"></i> Espace bénéficiaire</a></li>
                <li><a href="espace_benevole.php" class="nav-item"> <i class='fa-solid fa-hand-holding-heart'></i> Espace bénévole</a></li>
            </ul>
        </nav>
        <div class="dark-mode-toggle">
            <label class="switch">
                <input type="checkbox" id="darkModeToggle">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="search-icon">
            <a href="search.php"><i class="fa fa-search"></i></a>
        </div>
    </div>
</header>


<script>
        document.getElementById("hamburger-menu").addEventListener("click", function() {
            document.querySelector(".navigation-menu").classList.toggle("active");
        });
        document.getElementById("darkModeToggle").addEventListener("change", function() {
            var darkModeEnabled = this.checked;
            if (darkModeEnabled) {
                document.body.classList.add("dark-mode");
            } else {
                document.body.classList.remove("dark-mode");
            }
        });
    </script>