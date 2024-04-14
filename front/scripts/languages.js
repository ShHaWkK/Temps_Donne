//On charge la liste des langues à partir d'une API externe
document.addEventListener("DOMContentLoaded", function() {
    var languageSelect = document.getElementById('langues');
    var uniqueLanguages = new Set(); // Créer un ensemble pour stocker les langues uniques

    fetch('https://restcountries.com/v3.1/all?fields=languages')
        .then(response => response.json())
        .then(data => {
            data.forEach(function(country) {
                Object.values(country.languages).forEach(function(language) {
                    uniqueLanguages.add(language);
                });
            });

            uniqueLanguages.forEach(function(language) {
                var option = document.createElement('option');
                option.value = language;
                option.textContent = language;
                languageSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des données:', error);
        });
});

//On rend les langues sélectionnée en surbrillance
document.addEventListener("DOMContentLoaded", function() {
    var languageSelect = document.getElementById('langues');

    languageSelect.addEventListener('change', function() {
        Array.from(languageSelect.options).forEach(function(option) {
            if (option.selected) {
                option.style.backgroundColor = '#82CFD8';
                option.style.color = '#fff';
            } else {
                option.style.backgroundColor = '';
                option.style.color = '';
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var languageSelect = document.getElementById('langues');
    var selectedLanguagesInput = document.getElementById('selectedLanguages');

    // Stocker les langues sélectionnées
    var selectedLanguages = new Set();

    // Écouter l'événement click sur les options du select
    languageSelect.addEventListener('click', function(event) {
        var option = event.target;

        // Ajouter ou retirer la langue de l'ensemble des langues sélectionnées
        if (option.tagName === 'OPTION') {
            if (option.selected) {
                selectedLanguages.add(option.value);
            } else {
                selectedLanguages.delete(option.value);
            }

            // Mettre à jour les options sélectionnées
            updateSelectedOptions();
        }
    });

    // Mettre à jour les options sélectionnées et le champ de formulaire caché
    function updateSelectedOptions() {
        // Mettre à jour le champ de formulaire caché avec les langues sélectionnées séparées par des virgules
        selectedLanguagesInput.value = Array.from(selectedLanguages).join(',');

        // Mettre à jour l'apparence des options sélectionnées
        Array.from(languageSelect.options).forEach(function(option) {
            if (selectedLanguages.has(option.value)) {
                option.style.backgroundColor = '#82CFD8';
                option.style.color = '#fff';
            } else {
                option.style.backgroundColor = '';
                option.style.color = '';
            }
        });
    }
});



