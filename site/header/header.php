
    <header>
        <div class="header-container">
            <div class="logo-container">
                <img src="./images/logo.png" alt="Logo Au Temps Donné" class="logo">
            </div>
            <nav class="navigation-menu">
                <ul>
                    <li><a href="index.php" class="nav-item active">Accueil</a></li>
                    <li><a href="services.php" class="nav-item">Services</a></li>
                    <li><a href="espace_beneficiaire.php" class="nav-item">Espace bénéficiaire</a></li>
                    <li><a href="espace_benevole.php" class="nav-item">Espace bénévole</a></li>
                </ul>
            </nav>
            <div class="search-icon">
                <a href="search.php"><img src="./images/chercher.png" alt="Rechercher"></a>
            </div>
        </div>
    </header>

<style>
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #82CFD8;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #82CFD8; 
    padding: 10px 20px;
}

.logo-container .logo {
    height: 80px; 
}

.navigation-menu ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navigation-menu ul li .nav-item {
    display: block;
    padding: 10px 15px;
    background-color: #00334A; 
    color: white;
    text-decoration: none;
    border-radius: 5px; 
    margin-right: 10px; 
    transition: background-color 0.3s;
}

.navigation-menu ul li .nav-item.active,
.navigation-menu ul li .nav-item:hover {
    background-color: #004d40; 
}

.search-icon a {
    display: inline-block;
    background-color: #82CFD8;
    border-radius: 50%; 
    padding: 8px; 
}

.search-icon img {
    height: 30px; 
}

</style>