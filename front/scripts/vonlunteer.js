document.getElementById('formInscription').addEventListener('submit', function(e) {
    var errors = [];
    var nom = document.getElementById('nom').value;
    var prenom = document.getElementById('prenom').value;
    var email = document.getElementById('email').value;
    var telephone = document.getElementById('telephone').value;
    var nationalite = document.getElementById('nationalite').value;
    var adresse = document.getElementById('adresse').value;

    if (nom.length < 3) {
        errors.push('Le nom doit contenir au moins 3 caractères.');
    }

    if (prenom.length < 3) {
        errors.push('Le prénom doit contenir au moins 3 caractères.');
    }

    if (email.indexOf('@') === -1) {
        errors.push('Adresse e-mail invalide.');
    }

    if (telephone.length < 10) {
        errors.push('Numéro de téléphone invalide.');
    }

    if (nationalite.length < 3) {
        errors.push('Nationalité invalide.');
    }

    if (adresse.length < 5) {
        errors.push('Adresse invalide.');
    }

    if (errors.length > 0) {
        e.preventDefault();
        alert(errors.join('\n'));
    }
});

// * => obligatoire à remplir 
document.getElementById('volunteerRegistrationForm').addEventListener('submit', function(e) {
    var inputs = document.querySelectorAll('input, select, textarea');
    var errors = [];

    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].hasAttribute('required') && inputs[i].value === '') {
            errors.push('Le champ ' + inputs[i].name + ' est obligatoire.');
        }
    }

    if (errors.length > 0) {
        e.preventDefault();
        alert(errors.join('\n'));
    }
});