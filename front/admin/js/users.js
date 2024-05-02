let users = [];

async function getAllUsers() {
    const apiUrl = 'http://localhost:8082/index.php/users';

    const options = {
        method: 'GET'
    };
    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            alert('Erreur réseau');
        }
        users = await response.json();
        console.log(users);
        displayUsers(users);
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        return [];
    }
}

function displayUsers(users) {
    const usersTable = document.getElementById('usersTable');

    usersTable.innerHTML = ''; // Clear previous content

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
    /*
    for (let i = 0; i < tableHeader.length; i++) {
        const cell = rowHeader.insertCell();
        cell.textContent = tableHeader[i];
    }
*/
    users.forEach(user => {
        const row = usersTable.insertRow();
        row.innerHTML = `
                        <td>${user.ID_Utilisateur}</td>
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
                        <td><a href='#'>Valider</a></td>
                    `;
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const selectElement = document.getElementById("roleFilter");

    selectElement.addEventListener("change", function() {
        filterByRole(selectElement.value);
    });
});

function filterByRole(role) {
    if (role === 'all') {
        displayUsers(users);
    } else {
        const filteredUsers = users.filter(user => user.Role === role);
        displayUsers(filteredUsers);
    }
}

window.onload = function() {
    getAllUsers();
}