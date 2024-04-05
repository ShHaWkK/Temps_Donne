<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<header>
    <div class="header-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="./images/logo.png" alt="Logo Au Temps Donné" class="logo">
        </div>

        <!-- Boutons de navigation -->
        <nav class="navigation-menu">   
            <ul>
                <li><a href="index.php" class="nav-item active"><i class="fa fa-home"></i> Accueil</a></li>
                <li><a href="services.php" class="nav-item"><i class="fa-solid fa-users"></i> Services</a></li>
                <li><a href="dons.php" class="nav-item-space"><i class="fa-solid fa-hand-holding-dollar"></i> Faire un <br>don</a></li>
                <li><a href="espace_beneficiaire.php" class="nav-item-space"><i class="fa-solid fa-handshake"></i> Espace <br> bénéficiaire</a></li>
                <li><a href="espace_benevole.php" class="nav-item-space"> <i class='fa-solid fa-hand-holding-heart'></i> Espace <br>bénévole</a></li>
            </ul>
        </nav>

        <!-- Barre de recherche et icône de recherche -->
        <div class="search-container">
            <div class="search-icon">
                <input class="search-input" type="text" placeholder="Recherche..." id="searchInput">
                <a><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>

        <!-- Menu déroulant pour les langues -->
        <div class="popover-container">
            <button class="language-button" onclick="toggleLanguageList()">
                <img src="./images/france.png" width="30" height="30">
                <i class="icon icon--md icon--caret-down"></i>
            </button>
            <ul class="popover-content" id="languageList">
                <li>
                    <a href="https://www.flaticon.com/search?word=french" class="active track" >
                        <span class="text__general--heading">Français</span>
                    </a>
                </li>
                <li>
                    <a href="https://media.flaticon.com/dist/min/img/flags/en.svg" class="track">
                        <span class="text__general--heading">English</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Bouton de mode sombre -->
        <div class="dark-mode-toggle">
            <label class="switch">
                <input type="checkbox" id="darkModeToggle">
                <span class="slider round"></span>
            </label>
        </div>
    </div> 
</header>

<style>
    /*Menu déroulant pour les langues */
    .language-button{        
        padding: 15px;
        background-color: #00334A;
        border-radius: 50px;
        margin-right: 10px;
        transition: background-color 0.3s;
        display: flex; 
        align-items: center; 
        justify-content: center; 
        height: 50px; 
        width: 50px; 
        cursor: pointer;
    }
    
    .popover-container {
        position: relative;
        display: inline-block;
    }

    .popover-content {
        position: absolute;
        z-index: 1;
        top: 100%; 
        left: 50%; 
        transform: translateX(-50%); 
        display: none;
        overflow: visible;
        width: auto; 
        margin: 0;
        padding: 10px;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        background: #fff;
        box-shadow: 0 0 60px rgba(14,42,71,.25);
        animation: popover .2s ease-in-out;
        list-style-type: none;
        text-align: center; /* Centrer le texte */
    }



    .popover-content a {
        color: black;
        padding: 12px 12px;
        text-decoration: none;
        display: flex;
    }

    .popover-content a:hover {
        background-color: #f1f1f1;
    }

    .popover-container:hover .popover-content {
        display: block;
    }

    body, header {
    margin: 0;
    padding: 0;
    }

    .dark-mode {
        background-color: #434242; 
        color: #D3D2D2; 
    }

    .header-container {
        font-family: 'Poppins', sans-serif; 
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%; 
        background-color: #82CFD8; 
    }

    .logo-container {
        margin-left: 20px;
    }

    .logo-container .logo {
        max-width: 150px;
        max-height: 100px;
        height: auto; 
        padding: 10px 0;
    }

    .navigation-menu ul {
        list-style: none;
        display: flex;
        justify-content: center;
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
    .navigation-menu ul li .nav-item:hover,
    .navigation-menu ul li .nav-item-space.active,
    .navigation-menu ul li .nav-item-space:hover,
    .language-button:hover{
        background-color: #002233; 
    }

    .search-container {
        display: flex;
        white-space: nowrap;
        align-items: center;
    }

    .search-icon input[type="text"] {
        border: none;
        outline: none;
        padding: 10px;
        font-size: 16px;
        border: 3px solid;
        border-color: black;
        border-radius: 20px;
        width: 200px;
        background-color: #fff;
    }

    .search-icon a i {
        color: black;
        cursor: pointer;
        font-size: 24px;
        margin-right: 10px;
    }

    .search-icon a i:hover
    {
        color: #002233; 
        transform: scale(1.2);
    }

    .dark-mode-toggle {
        margin-right: 20px;
    }

    /* Styles du bouton de mode sombre */
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

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

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
            align-items: center; 
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

    function toggleLanguageList() {
    var languageList = document.getElementById("languageList");
    languageList.classList.toggle("show");
  }

</script>
