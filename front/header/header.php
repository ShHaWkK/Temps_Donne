<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<header>
    <div class="header-container">
        <div class="logo-container">
            <img src="./images/logo.png" alt="Logo Au Temps Donné" class="logo">
        </div>
        <nav class="navigation-menu">   
            <ul>
            <li><a href="index.php" class="nav-item active"><i class="fa fa-home"></i> Accueil</a></li>
            <li><a href="services.php" class="nav-item"><i class="fa-solid fa-users"></i> Services</a></li>
            <li><a href="dons.php" class="nav-item-space"><i class="fa-solid fa-hand-holding-dollar"></i> Faire un <br>don</a></li>
                <li><a href="espace_beneficiaire.php" class="nav-item-space"><i class="fa-solid fa-handshake"></i> Espace <br> bénéficiaire</a></li>
                <li><a href="espace_benevole.php" class="nav-item-space"> <i class='fa-solid fa-hand-holding-heart'></i> Espace <br>
                 bénévole</a></li>
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

<style>
.header-container {
    font-family: 'Poppins', sans-serif; 
}

body {
    display: block;
    margin: 0px;
}

.dark-mode {
    background-color: #434242; 
    color: #D3D2D2; 
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  background-image: url('./images/moon.png');  
  background-size: cover;
  background-repeat: no-repeat;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
  background-image: url('./images/sun.png');  
  background-size: cover;
  background-repeat: no-repeat;
}

/* Styles pour le bouton de bascule arrondi */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
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
    margin-left: 20px;
}

.logo-container .logo {
    max-width: 150px;
    max-height: 100px;
    height: auto; 
    padding: 10px 0;
}

.navigation-menu {
    flex: 3; 
}

.navigation-menu ul {
    list-style: none;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

.navigation-menu ul li {
    margin-right: 20px;
}

.navigation-menu ul li:last-child {
    margin-right: 0;
}

.navigation-menu ul li .nav-item {
    display: block;
    padding: 15px;
    background-color: #00334A;
    color: white;
    text-decoration: none;
    border-radius: 20px;
    margin-right: 10px;
    transition: background-color 0.3s;
    flex-grow: 1;
    height: 20px;
    width: 100px;
    max-width: 100px;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: break-word; 
}

.navigation-menu ul li .nav-item-space {
    display: block;
    padding: 10px;
    background-color: #00334A;
    color: white;
    text-decoration: none;
    border-radius: 20px;
    margin-right: 10px;
    transition: background-color 0.3s;
    flex-grow: 1;
    height: auto;
    width: 100px;
    max-width: 100px;
    text-align: center;
    vertical-align: top;
    line-height: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: break-word; 
}


.navigation-menu ul li .nav-item.active,
.navigation-menu ul li .nav-item:hover {
    background-color: #002233; 
}

.search-icon {
    flex: 0.5;
    display: flex;
    justify-content: center;
    align-items: center; /* Centrer verticalement l'icône */
    padding: 10px;
    width: 50px; 
    height: 50px;
}

.search-icon img {
    width: 50px; 
    height: 50px;
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
    display: flex;
    justify-content: space-between;
    align-items: center; /* Centre verticalement les éléments */
    width: 100%; 
    background-color: #82CFD8; 
}

    .logo-container, .search-icon {
        width: 100%; 
        justify-content: center; 
    }
}

</style>

<script>
        document.getElementById("darkModeToggle").addEventListener("change", function() {
            var darkModeEnabled = this.checked;
            if (darkModeEnabled) {
                document.body.classList.add("dark-mode");
            } else {
                document.body.classList.remove("dark-mode");
            }
        });
    </script>