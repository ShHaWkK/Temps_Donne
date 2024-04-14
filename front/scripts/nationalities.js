document.addEventListener("DOMContentLoaded", function() {
    var nationaliteSelect = document.getElementById('nationalite');

    fetch('https://restcountries.com/v3.1/all')
        .then(response => response.json())
        .then(data => {
            data.forEach(function(country) {
                var option = document.createElement('option');
                option.value = country.name.common;
                option.textContent = country.name.common;
                nationaliteSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des données:', error);
        });
});
