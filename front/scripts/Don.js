document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); // Assurez-vous que votre formulaire a un sélecteur unique ou ajoutez un id/class spécifique
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Empêcher la soumission standard du formulaire
        sendDonationDataToAPI();
    });
});

function sendDonationDataToAPI() {
    var montant = document.getElementById('montant').value;
    var type_don = document.getElementById('type_don').value;
    var date_don = new Date().toISOString().slice(0, 10); // Format ISO de la date
    var id_donateur = 1; // Cela devrait être remplacé par l'ID de l'utilisateur connecté, si applicable
    var commentaires = document.getElementById('commentaires').value;

    // Vérifier que les éléments nécessaires sont présents
    if (!montant || !type_don || !date_don || !id_donateur || !commentaires) {
        alert('Veuillez remplir tous les champs requis.');
        return;
    }

    var data = {
        montant: montant,
        type_don: type_don,
        date_don: date_don,
        id_donateur: id_donateur,
        commentaires: commentaires
    };

    fetch('http://localhost:8082/index.php/dons', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau ou serveur');
        }
        return response.json();
    })
    .then(json => {
        console.log("Réponse reçue:", json);
        alert('Don enregistré avec succès!');
    })
    .catch(error => {
        console.error('Erreur lors de l\'envoi des données:', error);
        alert('Erreur lors de l\'enregistrement du don.');
    });
}
