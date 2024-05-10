// Initialisation
window.onload = function() {
    checkSession()
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
            displayProducts('productFilter');
            displayProducts('productSelector');
            displayEntrepots('entrepotFilter');
            displayEntrepots('entrepotSelector');
            displayEntrepots('entrepotFilterCollecte');
            displayDrivers(allDrivers);
            displayTrucks(1);
            displayCommercants(allCommercants);
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
            initMap();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}