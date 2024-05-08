let allStocks = [];
let allProduits= [];
let allEntrepots = [];
let displayedStocks =[];
const currentDate = new Date();
let statutFilter='all';
let entrepotFilter='all';
let produitFilter='all';

async function getAllProducts(){
    return fetch('http://localhost:8082/index.php/produits')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des utilisateurs :', error);
            throw error;
        });
}

async function getAllEntrepots(){
    return fetch('http://localhost:8082/index.php/entrepots')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des utilisateurs :', error);
            throw error;
        });
}

function getProductName(products, id) {

    let productName = "Produit non trouvé";

    // Parcourir le tableau de produits
    products.forEach(product => {
        // Vérifier si l'ID du produit correspond à l'ID recherché
        if (product.ID_Produit == id) {
            // Affecter le nom du produit correspondant à la variable productName
            productName = product.Nom_Produit;
        }
    });

    return productName;
}

function getProductWeight(products, id) {
    let productWeight = "Produit non trouvé";

    // Parcourir le tableau de produits
    products.forEach(product => {
        console.log("foreach id",product.ID_Produit);
        console.log(product.ID_Produit === id);
        // Vérifier si l'ID du produit correspond à l'ID recherché
        if (product.ID_Produit == id) {
            // Affecter le nom du produit correspondant à la variable productName
            productWeight = product.Poids;
        }
    });

    return productWeight;
}

function getProductVolume(products, id) {
    console.log("id get", id);
    console.log("products get", products);

    let productVolume = "Produit non trouvé";

    // Parcourir le tableau de produits
    products.forEach(product => {
        // Vérifier si l'ID du produit correspond à l'ID recherché
        if (product.ID_Produit == id) {
            productVolume = product.Volume;
        }
    });

    return productVolume;
}

// Module pour la récupération des utilisateurs
async function getAllStocks() {
    return fetch('http://localhost:8082/index.php/stocks')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des utilisateurs :', error);
            throw error;
        });
}

function displayStocks(stocks, produitFiltre, statutFiltre, entrepotFiltre, tri) {
    const stockTable = document.getElementById('stockTable');

    //On réinitialise le contenu de la table
    stockTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["","ID", "Produit", "Quantite", "Poids Total", "Volume Total", "Date de reception","Date de péremption", "Statut", "Détails"];

    const rowHeader = stockTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    // Filtrer les stocks en fonction des filtres sélectionnés
    let stocksFiltres = stocks.filter(stock => {
        let produitCorrespond = produitFiltre !== 'all' ? (stock.ID_Produit == produitFiltre) : true;
        let entrepotCorrespond = entrepotFiltre !== 'all' ? (stock.ID_Entrepots == entrepotFiltre) : true;
        let statutCorrespond = statutFiltre !== 'all' ? (stock.Statut == statutFiltre) : true;
        return produitCorrespond && entrepotCorrespond && statutCorrespond;
    });

    // Trier les stocks filtrés en fonction du critère de tri
    switch(tri) {
        case 'ID':
            stocksFiltres = sortByID(stocksFiltres);
            break;
        case 'DateReceptionAsc':
            stocksFiltres = sortByDateReception(stocksFiltres);
            break;
        case 'DateReceptionDesc':
            stocksFiltres = sortByDateReception(stocksFiltres, true);
            break;
        case 'DatePeremptionAsc':
            stocksFiltres = sortByDatePeremption(stocksFiltres);
            break;
        case 'DatePeremptionDesc':
            stocksFiltres = sortByDatePeremption(stocksFiltres, true);
            break;
        default:
            stocksFiltres = sortByID(stocksFiltres);
            break;
    }
    let firstStock = true;
    // Afficher les stocks filtrés et triés
    stocksFiltres.forEach(stock => {
        const row = stockTable.insertRow();
        row.innerHTML = `
             <td> <input type="radio" id=${stock.ID_Stock} name='id_buttons' value=${stock.ID_Stock} ${firstStock ? 'checked' : ''} /> </td>
            <td class="stock-id">${stock.ID_Stock}</td>
            <td>${getProductName(allProduits, stock.ID_Produit)}</td>
            <td>${stock.Quantite}</td>
            <td>${stock.Poids_Total} kg</td>
            <td>${stock.Volume_Total} m²</td>
            <td>${stock.Date_de_reception}</td>
            <td>${stock.Date_de_peremption}</td>
            <td>${stock.Statut}</td>
            <td><button class="popup-button stockDetails">Voir</button></td>
        `;
        // Vérifier si la date de péremption est antérieure à la date actuelle
        const expirationDate = new Date(stock.Date_de_peremption);
        if (expirationDate < currentDate) {
            row.classList.add('expired');
        }
        firstStock=false;
    });
}

async function displayProducts(element_id) {
    const productFilter = document.getElementById(element_id);

    try {
        allProduits.forEach(produit => {
            const option = document.createElement('option');
            option.value = produit.ID_Produit;
            option.textContent = produit.Nom_Produit;
            productFilter.appendChild(option);
        });
    } catch (error) {
        console.error('Une erreur s\'est produite lors de la récupération des types de service :', error);
    }
}

async function displayEntrepots(element_id) {
    const entrepotFilter = document.getElementById(element_id);

    try {
        allEntrepots.forEach(entrepot => {
            const option = document.createElement('option');
            option.value = entrepot.ID_Entrepot;
            option.textContent = entrepot.Nom;
            entrepotFilter.appendChild(option);
        });
    } catch (error) {
        console.error('Une erreur s\'est produite lors de la récupération des types de service :', error);
    }
}

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
        .then(() => {
            displayProducts('productFilter');
            displayEntrepots('entrepotFilter');
            displayProducts('productSelector');
            displayEntrepots('entrepotSelector');
        })
        .then(() => {
            addProductFilterEvent();
            addEntrepotFilterEvent();
            addStatusFilterEvent();
            addSortEvents();
            addAddStockEvent();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}