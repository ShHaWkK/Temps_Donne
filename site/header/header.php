
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
    font-family: 'Arial', sans-serif;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%; 
    background-color: #82CFD8; 
}

.logo-container {
    flex: 1; 
}

.logo-container .logo {
    width: auto; 
    max-height: 60px; 
    padding: 10px;
}

.navigation-menu {
    flex: 3; 
}

.navigation-menu ul {
    list-style: none;
    display: flex;
    justify-content: space-around; 
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
    background-color: #002233; 
}
.search-icon {
    flex: 0.5; 
    display: flex;
    justify-content: center; 
    padding: 10px;
}

.search-icon img {
    width: 32px; 
}

/* Media queries  */
@media (max-width: 768px) {
    .navigation-menu ul {
        flex-direction: column; 
        align-items: center;
    }

    .navigation-menu ul li {
        padding: 5px;
    }

    .logo-container .logo {
        max-height: 40px; 
    }
}

@media (max-width: 480px) {
    .header-container {
        flex-direction: column; 
    }

    .logo-container, .search-icon {
        width: 100%; 
        justify-content: center; 
    }
}

</style>