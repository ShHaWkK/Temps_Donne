let users = [];

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

function displayUsers(users) {
    const usersTable = document.getElementById('usersTable');

    usersTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["ID_Utilisateur", "Nom", "Prénom", "Genre", "Date de naissance", "Email",
        "Telephone","Nationalité","Emploi","Role","Statut","Type_Permis","Action"];

    const rowHeader = usersTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    users.forEach(user => {
        const row = usersTable.insertRow();
        row.innerHTML = `
                        <td class="user-id">${user.ID_Utilisateur}</td>
                        <td>${user.Nom}</td>
                        <td>${user.Prenom}</td>
                        <td>${user.Genre}</td>
                        <td>${user.Date_de_naissance}</td>
                        <td>${user.Email}</td>
                        <td>${user.Telephone}</td>
                        <td>${user.Nationalite}</td>
                        <td>${user.Emploi}</td>
                        <td>${user.Role}</td>
                        <td>${user.Statut}</td>
                        <td>${user.Type_Permis}</td>
                        <td><a href='#' class="approve-link">Valider</a></td>
                    `;
    });
}


// Initialisation
window.onload = function() {
    getAllUsers()
        .then(users => {
            displayUsers(users);
            addApproveEventListeners();
            addFilterByRoleEvent(users);
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des utilisateurs :', error);
        });
};

// window.onload = function() {
    // getAllUsers();
// }