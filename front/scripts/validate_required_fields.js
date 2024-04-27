// Fonction pour valider les champs obligatoires avant d'envoyer les données à l'API
function validateFormAndSendData() {
    // Récupérer les champs obligatoires
    var requiredFields = document.querySelectorAll('[required]');


    for (var i = 0; i < requiredFields.length; i++) {
        var field = requiredFields[i];

        if (field.type === 'radio') {
            var radioGroup = document.getElementsByName(field.name);

            var isChecked = false;
            for (var j = 0; j < radioGroup.length; j++) {
                if (radioGroup[j].checked) {
                    isChecked = true;
                    break;
                }
            }

            if (!isChecked) {
                radioGroup[0].scrollIntoView({ behavior: 'smooth', block: 'center' });

                for (var k = 0; k < radioGroup.length; k++) {
                    radioGroup[k].style.outline = '2px solid red';
                }

                return false;
            }
        } else if (field.value === '') {
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });

            field.style.border = '2px solid red';

            return false;
        }
    }

    sendDataToAPI();
}

// Événement de clic sur le bouton de validation
document.getElementById('validationButton').addEventListener('click', function(event) {
    // Empêcher le comportement par défaut du bouton
    event.preventDefault();
    validateFormAndSendData();
});