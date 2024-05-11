// Initialisation
window.onload = function() {
    checkSession()
        .then(() => {
            return getAllFormations();
        })
        .then(formations => {
            console.log(formations);
            displayFormations(formations);
        })
        .then(() => {
            return getAllInscriptions();
        })
        .then(inscriptions => {
            console.log(inscriptions);
            displayInscriptions(inscriptions)
                .then(() => {
                    addUserDetailsModalEventListeners();
                    addFormationDetailsListeners();
                });
        })
        .then(() => {
            // addFormationDetailsListeners();
            // addNextSessionsListeners();
            // addInscriptionListener();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}