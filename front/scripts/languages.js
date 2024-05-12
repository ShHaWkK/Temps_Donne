document.addEventListener("DOMContentLoaded", function() {
    var languageSelect = document.getElementById('langues');
    var uniqueLanguages = new Set();
    var selectedLanguages = new Set();
    var selectedLanguagesInput = document.getElementById('selectedLanguages');

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

    languageSelect.addEventListener('change', function(event) {
        var option = event.target;

        if (option.tagName === 'SELECT') {
            if (option.selected) {
                selectedLanguages.add(option.value);
            } else {
                selectedLanguages.delete(option.value);
            }

            updateSelectedOptions();
        }
    });

    function updateSelectedOptions() {
        selectedLanguagesInput.value = Array.from(selectedLanguages).join(',');

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

    var languesSelect = document.getElementById('langues');
    languesSelect.addEventListener('change', function() {
        var selectedLanguages = [];
        for (var i = 0; i < languesSelect.options.length; i++) {
            if (languesSelect.options[i].selected) {
                selectedLanguages.push(languesSelect.options[i].value);
            }
        }
        console.log('Changement de langues sélectionnées:', selectedLanguages);
    });
});