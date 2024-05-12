    // Fonction pour charger le mode à partir de localStorage
    function loadModeFromLocalStorage() {
        var mode = localStorage.getItem('mode');

        if (mode === 'dark') {
            document.body.classList.add("dark-mode");
            document.getElementById("darkModeToggle").checked = true; // Cocher l'interrupteur
            // Détection du mode sombre et mise à jour de la variable CSS en conséquence
            document.documentElement.style.setProperty('--margin-color', '#434242');
        } else {
            document.body.classList.remove("dark-mode");
            document.getElementById("darkModeToggle").checked = false; // Décocher l'interrupteur
            document.documentElement.style.setProperty('--margin-color', '#D3D2D2');
        }
    }

    // Charger le mode au chargement de la page
    window.onload = function() {
    console.log("darkmode");
        loadModeFromLocalStorage();
    };

    // Écouter les changements de l'interrupteur
    document.getElementById("darkModeToggle").addEventListener("change", function() {
        var darkModeEnabled = this.checked;
        if (darkModeEnabled) {
            document.body.classList.add("dark-mode");
            localStorage.setItem('mode', 'dark'); 
        } else {
            document.body.classList.remove("dark-mode");
            localStorage.setItem('mode', 'light'); 
        }
    });