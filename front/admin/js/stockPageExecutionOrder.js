// Initialisation
window.onload = function() {
    checkSessionVolunteer()
        .then(()=> {
            return getAllProducts();
        })
        .then(produits => {
            allProduits = produits;
        })
        .then(()=> {
            return getAllEntrepots();
        })
        .then(entrepots => {
            allEntrepots = entrepots;
        })
        .then(() => {
            return getAllStocks();
        })
        .then(stocks => {
            allStocks = stocks;
            displayedStocks=stocks;
            displayStocks(allStocks,produitFilter,statutFilter,entrepotFilter);
        })
        .then(()=> {
            return getAllUsers();
        })
        .then(users => {
            allUsers = users;
        })
        .then(()=> {
            return getAllTrucks();
        })
        .then(trucks => {
            allTrucks = trucks;
        })
        .then(()=> {
            return getDrivers(allUsers,'6 Boulevard Gambetta, Saint-Quentin, France');
        })
        .then(drivers => {
            allDrivers = drivers;
        })
        .then(()=> {
            return getAllCommercants();
        })
        .then(commercants => {
            allCommercants = commercants;
        })
        .then(() => {
            addProductFilterEvent();
            addEntrepotFilterEvent();
            addStatusFilterEvent();
            addSortEvents();
            addAddStockEvent();
            addSelectedButtonEvent();
            addUserDetailsModalEventListeners();
            addEntrepotFilterCollecteEvent();
        })
        .then(async () => {
            displayProducts('productFilter');
            displayProducts('productSelector');
            displayEntrepots('entrepotFilter');
            displayEntrepots('entrepotSelector');
            displayEntrepots('entrepotFilterCollecte');
            displayDrivers(allDrivers);
            displayTrucks(1);
            let filteredCommercants = await filterCommercants(allCommercants, '6 boulevard Gambetta, Saint Quentin, France');
            console.log("filteredCommcercants", filteredCommercants);
            displayCommercants(filteredCommercants);

            // On centre la carte sur l'entrepot sélectionné par défaut
            let selectedEntrepot = document.querySelector('select[name="entrepotFilterCollecte"]').value;
            let address = getEntrepotAddress(allEntrepots, selectedEntrepot);
            latLong = await geocodeAddress(address);

            initMap(latLong);
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}