function logout() {
    // Supprimer le cookie de session
    document.cookie = 'session_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    document.cookie = 'user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';

    // Rediriger vers la page de connexion
    window.location.href = "../index.php";
}


document.getElementById('logoutButton').addEventListener('click', function(event) {
    // Empêcher le comportement par défaut du bouton
    event.preventDefault();

    logout();

    document.addEventListener('DOMContentLoaded', function() {
        // Sélection de l'élément de déconnexion
        var logoutButton = document.getElementById('logoutButton');

        // Ajout d'un écouteur d'événement clic
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du lien

            // Appeler la fonction de déconnexion avec le rôle approprié
            logout();
        });
    });

});
