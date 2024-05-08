let allStocks = [];
let displayedStocks =[];

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
    console.log("id get", id);
    console.log("products get", products);

    let productName = "Produit non trouvé";

    // Parcourir le tableau de produits
    products.forEach(product => {
        console.log("foreach",product);
        console.log("foreach id",product.ID_Produit);
        console.log(product.ID_Produit === id);
        console.log(product.Nom_Produit);
        // Vérifier si l'ID du produit correspond à l'ID recherché
        if (product.ID_Produit === id) {
            // Affecter le nom du produit correspondant à la variable productName
            productName = product.Nom_Produit;
        }
    });

    return productName;
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

function displayStocks(stocks, produitFiltre, statutFiltre, entrepotFiltre) {
    const stockTable = document.getElementById('stockTable');

    //On réinitialise le contenu de la table
    stockTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["ID", "Produit", "Quantite", "Poids Total", "Volume Total", "Date de reception", "Statut", "Détails"];

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
        console.log("produitCorrespond", produitFiltre + '=' + stock.ID_Produit + '=' + produitCorrespond);
        let entrepotCorrespond = entrepotFiltre !== 'all' ? (stock.ID_Entrepots == entrepotFiltre) : true;
        console.log("entrepotCorrespond", entrepotFiltre + '=' + stock.ID_Entrepot + '=' + entrepotCorrespond);
        let statutCorrespond = statutFiltre !== 'all' ? (stock.Statut == statutFiltre) : true;
        console.log("statutCorrespond", statutFiltre + '=' + stock.Statut + '=' + statutCorrespond);
        return produitCorrespond && entrepotCorrespond && statutCorrespond;
    });

    // Afficher les stocks filtrés
    stocksFiltres.forEach(stock => {
        const row = stockTable.insertRow();
        row.innerHTML = `
            <td class="stock-id">${stock.ID_Stock}</td>
            <td>${getProductName(allProduits, stock.ID_Produit)}</td>
            <td>${stock.Quantite}</td>
            <td>${stock.Poids_Total} kg</td>
            <td>${stock.Volume_Total} m²</td>
            <td>${stock.Date_de_reception}</td>
            <td>${stock.Statut}</td>
            <td><button class="popup-button stockDetails">Voir</button></td>
        `;
    });
}

async function displayProducts() {
    const productFilter = document.getElementById('productFilter');

    console.log("displayProducts");

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

async function displayEntrepots() {
    const entrepotFilter = document.getElementById('entrepotFilter');

    console.log("displayEntrepots");

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
            console.log("displayStocks");
            displayStocks(allStocks,produitFilter,statutFilter,entrepotFilter);
        })
        .then(() => {
            displayProducts();
            displayEntrepots()
        })
        .then(() => {
            addProductFilterEvent();
            addEntrepotFilterEvent();
            addStatusFilterEvent();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}