//On utilise une API externe pour sélectionner la liste des banques:
document.addEventListener("DOMContentLoaded", function() {
    var bankSelect = document.getElementById('bank-select');

    // Appel de l'API Open Bank Project pour récupérer la liste des banques
    fetch('https://api.openbankproject.com/obp/v4.0.0/banks')
        .then(response => response.json())
        .then(data => {
            // Filtrer la liste pour ne récupérer que les banques françaises
            var frenchBanks = data.filter(bank => bank.country === 'FR');

            // Remplir le menu déroulant avec les banques françaises
            frenchBanks.forEach(function(bank) {
                var option = document.createElement('option');
                option.value = bank.id;
                option.textContent = bank.full_name;
                bankSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des données:', error);
        });
});