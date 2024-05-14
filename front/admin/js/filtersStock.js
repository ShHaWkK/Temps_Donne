//Récupérer informations des entrepots:
let selectedStock;
function getEntrepotName(entrepots, id) {

    let entrepotName = "Entrepot non trouvé";

    // Parcourir le tableau de produits
    entrepots.forEach(entrepot => {
        // Vérifier si l'ID du produit correspond à l'ID recherché
        if (entrepot.ID_Entrepot == id) {
            // Affecter le nom du produit correspondant à la variable productName
            entrepotName = entrepot.Nom;
        }
    });

    return entrepotName;
}

function getEntrepotAddress(entrepots, id) {

    let entrepotAddress = "Entrepot non trouvé";

    // Parcourir le tableau de produits
    entrepots.forEach(entrepot => {
        // Vérifier si l'ID du produit correspond à l'ID recherché
        if (entrepot.ID_Entrepot == id) {
            // Affecter le nom du produit correspondant à la variable productName
            entrepotAddress = entrepot.Adresse;
        }
    });

    return entrepotAddress;
}

//Fonctions de filtres
function addProductFilterEvent(){
    const selectElement = document.getElementById("productFilter");

    selectElement.addEventListener("change", function() {
        produitFilter=selectElement.value;
        console.log("produitFilter");
        displayStocks(allStocks,produitFilter,statutFilter,entrepotFilter);
    });
}

function addStatusFilterEvent(){
    const selectElement = document.getElementById("statusFilter");

    selectElement.addEventListener("change", function() {
        statutFilter=selectElement.value;
        displayStocks(allStocks,produitFilter,statutFilter,entrepotFilter);
    });
}

function addEntrepotFilterEvent(){
    const selectElement = document.getElementById("entrepotFilter");

    selectElement.addEventListener("change", function() {

        //On récupère l'id de l'entrepot sélectionné
        entrepotFilter=selectElement.value;

        //On affiche le nom de l'entrepot sélectionné:
        const progressBar = document.querySelector('#progress');
        const entrepotNameElement = document.querySelector('.EntrepotName');
        if(entrepotFilter !== 'all'){
            entrepotNameElement.textContent = 'Entrepot de ' + getEntrepotName(allEntrepots,entrepotFilter);
            progressBar.display = 'block';
        }else{
            entrepotNameElement.textContent = '';
            progressBar.style.display = 'none';
        }

        displayStocks(allStocks,produitFilter,statutFilter,entrepotFilter);
    });
}

function addEntrepotFilterCollecteEvent(){
    const selectElement = document.getElementById("entrepotFilterCollecte");
    selectElement.addEventListener("change", async function () {
        entrepotFilter = selectElement.value;
        displayTrucks(selectElement.value);
        entrepotAddress = getEntrepotAddress(allEntrepots, selectElement.value);
        console.log(entrepotAddress);
        getDrivers(allUsers, entrepotAddress)
            .then(drivers => {
                displayDrivers(drivers);
                addUserDetailsModalEventListeners();
            })
        let filteredCommercants = await filterCommercants(allCommercants, '6 boulevard Gambetta, Saint Quentin, France');
        console.log("filteredCommcercants addEntrepotEvent", filteredCommercants);
        displayCommercants(filteredCommercants);
    });
}

// Fonctions de tri
function addSortEvents() {
    const sortElements = document.querySelectorAll("[name='Sort']");

    sortElements.forEach(element => {
        element.addEventListener("change", function() {
            displayStocks(allStocks, produitFilter, statutFilter, entrepotFilter, element.value);
        });
    });
}

function sortByID(stocks) {
    return stocks.sort((a, b) => a.ID_Stock - b.ID_Stock);
}

function sortByDateReception(stocks, descending = false) {
    return stocks.sort((a, b) => {
        const dateA = new Date(a.Date_de_reception);
        const dateB = new Date(b.Date_de_reception);
        return descending ? dateB - dateA : dateA - dateB;
    });
}

function sortByDatePeremption(stocks, descending = false) {
    return stocks.sort((a, b) => {
        const dateA = new Date(a.Date_de_peremption);
        const dateB = new Date(b.Date_de_peremption);
        return descending ? dateB - dateA : dateA - dateB;
    });
}

//On récupère le stock sélectionné:
function addSelectedStockButtonEvent(){
    const buttons = document.getElementsByName("id_buttons_stocks");

// Parcourir tous les boutons radio et ajouter un écouteur d'événement de changement à chacun
    buttons.forEach(button => {
        button.addEventListener('change', function() {
            // Vérifier si le bouton est coché
            if (this.checked) {
                // Mettre à jour la valeur sélectionnée avec la value du bouton coché
                selectedStock = this.value;
                console.log("La valeur sélectionnée est : ", selectedStock);
            }
        });
    });
}