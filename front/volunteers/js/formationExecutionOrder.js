// Initialisation
window.onload = function() {
    checkSession()
        .then(() => {
            return getAllFormations();
        })
        .then(formations => {
            displayFormations(formations,'available-formations');
        })
        .then(() => {
            return getUserFormations();
        })
        .then(formations => {
            displayFormations(formations,'my-formations');
        })
        .then(() => {
            addFormationDetailsListeners();
            addInscriptionListener();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}