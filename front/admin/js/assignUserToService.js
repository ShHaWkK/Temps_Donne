function getAllVolunteers() {
    return fetch('http://localhost:8082/index.php/volunteers/Granted')
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

function displayVolunteers() {
    getAllVolunteers()
        .then(volunteers => {
            const usersTable = document.getElementById('usersTable');

            usersTable.innerHTML = '';

            // On ajoute l'en-tête du tableau
            const tableHeader = ["","ID_Utilisateur", "Nom", "Prénom", "Genre", "Email"];

            const rowHeader = usersTable.insertRow();
            rowHeader.classList.add("head");

            for (let i = 0; i < tableHeader.length; i++) {
                const th = document.createElement("th");
                th.textContent = tableHeader[i];
                rowHeader.appendChild(th);
            }

            volunteers.forEach(volunteer => {
                const row = usersTable.insertRow();
                row.innerHTML = `
                    <td><input type="checkbox" id=${volunteer.ID_Utilisateur} name='id_checkboxes' value=${volunteer.ID_Utilisateur}></td>
                    <td class="user-id">${volunteer.ID_Utilisateur}</td>
                    <td>${volunteer.Nom}</td>
                    <td>${volunteer.Prenom}</td>
                    <td>${volunteer.Genre}</td>
                    <td>${volunteer.Email}</td>
                `;
            });
        })
        .catch(error => {
            console.error('Erreur lors de l\'affichage des volontaires :', error);
        });
}

function assignUsers(selectedUsers, service){
    selectedUsers.forEach(user =>{
        assignUser(user,service);
    })

}

function assignUser(user,service){
    apiUrl;
}