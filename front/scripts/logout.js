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

    // Afficher une boîte de dialogue de confirmation
    const userConfirmed = confirm('Êtes-vous sûr de vouloir vous déconnecter ?');

    // Si l'utilisateur confirme, effectuer la déconnexion
    if (userConfirmed) {
    logout();
} else {
    // Si l'utilisateur annule, ne rien faire
    console.log('Déconnexion annulée');
}
});