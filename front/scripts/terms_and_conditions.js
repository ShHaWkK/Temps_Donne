// Récupérer les éléments du DOM
var termsLink = document.getElementById('termsLink');
var modal = document.getElementById('termsModal');
var closeBtn = document.getElementsByClassName('close')[0];

// Lorsque l'utilisateur clique sur le lien des termes
termsLink.onclick = function() {
    modal.style.display = 'block'; // Afficher la fenêtre modale
}

// Lorsque l'utilisateur clique sur le bouton "fermer"
closeBtn.onclick = function() {
    modal.style.display = 'none'; // Masquer la fenêtre modale
}

// Lorsque l'utilisateur clique en dehors de la fenêtre modale, elle se ferme
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none'; // Masquer la fenêtre modale
    }
}

// Lorsque l'utilisateur clique sur le lien des termes
termsLink.onclick = function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien
    modal.style.display = 'block'; // Afficher la fenêtre modale
}