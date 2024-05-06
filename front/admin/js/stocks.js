let allUsers = [];
let displayedUsers =[];

// Module pour la récupération des utilisateurs
function getAllUsers() {
    return fetch('http://localhost:8082/index.php/users')
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
    const stocksTable = document.getElementById('stocksTable');

    stocksTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["ID_Stock", "ID_Entrepots", "ID_Produit", "Quantite", "Poids_Total", "Volume_Total", "Date_de_reception", "Statut", "QR_Code", "Date_de_peremption", "Détails", "Action"];

    const rowHeader = stocksTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    stocks.forEach(stock => {
        const row = stocksTable.insertRow();
        row.innerHTML = `
                        <td class="stock-id">${stock.ID_Stock}</td>
                        <td>${stock.ID_Entrepots}</td>
                        <td>${stock.ID_Produit}</td>
                        <td>${stock.Quantite}</td>
                        <td>${stock.Poids_Total}</td>
                        <td>${stock.Volume_Total}</td>
                        <td>${stock.Date_de_reception}</td>
                        <td>${stock.Statut}</td>
                        <td>${stock.QR_Code}</td>
                        <td>${stock.Date_de_peremption}</td>
                        <td><button class="popup-button stockDetails"> Voir </button></td>
                        <td>
                            <a href='#' class="reserve-link">Réserver</a>
                            <a href='#' class="release-link">Libérer</a>
                            <a href='#' class="remove-link">Supprimer</a>
                        </td>
                    `;
    });
}

// Initialisation
window.onload = function() {
    checkSession()
        .then(() => {
            return getAllUsers();
        })
        .then(users => {
            allUsers = users;
            displayedUsers=users;
            console.log(allUsers);
            displayUsers(allUsers);
        })
        .then(() => {
            addFilterByRoleEvent();
        })
        .then(() => {
            addFilterByStatusEvent();
        })
        .then(() => {
            addApproveEventListeners();
            addHoldEventListeners();
            addRejectEventListeners();
            addUserDetailsModalEventListeners();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}