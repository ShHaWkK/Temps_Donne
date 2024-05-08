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

    console.log("On entre dans filterByStatusEvent");
    selectElement.addEventListener("change", function() {
        statutFilter=selectElement.value;
        displayStocks(allStocks,produitFilter,statutFilter,entrepotFilter);
    });
}

function addEntrepotFilterEvent(){
    const selectElement = document.getElementById("entrepotFilter");

    console.log("On entre dans filterByEntrepotEvent");
    selectElement.addEventListener("change", function() {
        entrepotFilter=selectElement.value;
        displayStocks(allStocks,produitFilter,statutFilter,entrepotFilter);
    });
}

function addSortEvents() {
    const sortElements = document.querySelectorAll("[name='Sort']");

    sortElements.forEach(element => {
        element.addEventListener("change", function() {
            displayStocks(allStocks, produitFilter, statutFilter, entrepotFilter, element.value);
        });
    });
}
//Fonctions de tri
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