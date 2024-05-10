let allUsers = [];
let displayedUsers =[];
let selectedUser = null;

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
    //On vérifie si le paramètre est valide
    if (!Array.isArray(users)) {
        console.error("Le paramètre 'services' doit être un tableau.");
        return;
    }

    const usersTable = document.getElementById('usersTable');

    usersTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["","ID_Utilisateur", "Nom", "Prénom", "Genre", "Date de naissance", "Email",
        "Telephone","Role","Statut","Détails"];

    const rowHeader = usersTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    let firstUser = true;
    users.forEach(user => {
        if (!(getCookie('user_id') == user.ID_Utilisateur)) {
        const row = usersTable.insertRow();
            row.innerHTML = `
                        <td> <input type="radio" id=${user.ID_Utilisateur} name='id_buttons' value=${user.ID_Utilisateur} ${firstUser ? 'checked' : ''} /> </td>
                        <td class="user-id">${user.ID_Utilisateur}</td>
                        <td>${user.Nom}</td>
                        <td>${user.Prenom}</td>
                        <td>${user.Genre}</td>
                        <td>${user.Date_de_naissance}</td>
                        <td>${user.Email}</td>
                        <td>${user.Telephone}</td>
                        <td>${user.Role}</td>
                        <td>${user.Statut}</td>
                        <td><button class="popup-button userDetails"> Voir </button></td>
                    `;
            if (firstUser === true) {
                selectedUser = user.ID_Utilisateur;
            }
            firstUser = false;
        }
    });
}

// Parcourir tous les boutons radio et ajouter un écouteur d'événement de changement à chacun
function addSelectedButtonEvent(){
    const buttons = document.getElementsByName('id_buttons');

// Parcourir tous les boutons radio et ajouter un écouteur d'événement de changement à chacun
    buttons.forEach(button => {
        button.addEventListener('change', function() {
            // Vérifier si le bouton est coché
            if (this.checked) {
                // Mettre à jour la valeur sélectionnée avec la value du bouton coché
                selectedUser = this.value;
                console.log("La valeur sélectionnée est : ", selectedUser);
            }
        });
    });
}