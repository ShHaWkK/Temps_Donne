// Initialisation
window.onload = function() {
    checkSession()
        .then(() => {
            return getAllFormations();
        })
        .then(formations => {
            return displayFormations(formations)
        })
        .then(() => {
            // addFormationSeancesListeners();
            return getAllInscriptions();
        })
        .then(inscriptions => {
            displayInscriptions(inscriptions)
                .then(() => {
                    addUserDetailsModalEventListeners();
                    addFormationDetailsListeners();
                    addStatusButtonEventListener();
                    addFormationSeancesListeners();
                });
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}