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
