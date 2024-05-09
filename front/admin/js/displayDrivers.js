//---------------------------- Fonction pour faire apparaître la liste des chauffeurs potentiels dans un tableau
function displayDrivers(users) {
    const usersTable = document.getElementById('driverTable');

    usersTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["","Nom", "Prénom", "Genre", "Date de naissance",
        "Adresse","Détails"];

    const rowHeader = usersTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    let firstUser = true;
    users.forEach(user => {
        const row = usersTable.insertRow();
        row.innerHTML = `
                        <td> <input type="radio" id=${user.ID_Utilisateur} name='id_buttons' value=${user.ID_Utilisateur} ${firstUser ? 'checked' : ''} /> </td>
                        <td>${user.Nom}</td>
                        <td>${user.Prenom}</td>
                        <td>${user.Genre}</td>
                        <td>${user.Date_de_naissance}</td>
                        <td>${user.Adresse}</td>
                        <td><button class="popup-button userDetails"> Voir </button></td>
                    `;
        if (firstUser === true){
            selectedUser = user.ID_Utilisateur;
        }
        firstUser = false;
    });
}