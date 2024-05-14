// Initialisation
    checkSession()
        .then(() => {
            console.log("we are here");
            return getAllDemands();
        })
        .then(demands => {
            console.log("demands",demands);
            return displayDemands(demands)
        })
        .then(()=>{
            addSelectedDemandButtonEvent();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
