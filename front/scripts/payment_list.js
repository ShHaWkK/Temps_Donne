//Mode de paiement interractifs:
document.addEventListener("DOMContentLoaded", function() {
    var paymentButtons = document.querySelectorAll('.payment-button');
    var paymentDetailsDivs = document.querySelectorAll('.payment-details');

// Fonction pour afficher les détails de paiement appropriés en fonction de la sélection
    function showPaymentDetails(paymentMethod) {
        // Masquer tous les détails de paiement
        paymentDetailsDivs.forEach(function(div) {
            div.style.display = 'none';
        });

        // Afficher les détails de paiement appropriés en fonction de la sélection
        var selectedPaymentDetailsDiv = document.getElementById(paymentMethod + '-details');
        if (selectedPaymentDetailsDiv) {
            selectedPaymentDetailsDiv.style.display = 'block';
        }

        // Activer le bouton cliqué et désactiver les autres boutons
        paymentButtons.forEach(function(button) {
            if (button.getAttribute('data-payment-method') === paymentMethod) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }

    // Ajouter un écouteur d'événements de clic à chaque bouton de paiement
    paymentButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var paymentMethod = button.getAttribute('data-payment-method');
            showPaymentDetails(paymentMethod);
        });
    });
});
