let allStocks = [];
let displayedStocks =[];

let allProduits = [];

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

function displayStocks(stocks) {
    const stockTable = document.getElementById('stockTable');

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

    stocks.forEach(stock => {
        const row = stockTable.insertRow();
        let produit=getProductName(allProduits,stock.ID_Produit);
        row.innerHTML = `
                        <td class="stock-id">${stock.ID_Stock}</td>
                        <td>${produit}</td>
                        <td>${stock.Quantite}</td>
                        <td>${stock.Poids_Total} kg</td>
                        <td>${stock.Volume_Total} m²</td>
                        <td>${stock.Date_de_reception}</td>
                        <td>${stock.Statut}</td>
                        <td><button class="popup-button stockDetails"> Voir </button></td>
                    `;
    });
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
        .then(() => {
            return getAllStocks();
        })
        .then(stocks => {
            allStocks = stocks;
            displayedStocks=stocks;
            console.log("displayStocks");
            displayStocks(allStocks);
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}