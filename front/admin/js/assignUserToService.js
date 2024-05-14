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

function getAllBeneficiaries() {
    return fetch('http://localhost:8082/index.php/beneficiaries/Granted')
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

function displayBeneficiaries() {
    console.log("displayBeneficiaries");
    getAllBeneficiaries()
        .then(beneficiaries => {
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

            beneficiaries.forEach(beneficiary => {
                const row = usersTable.insertRow();
                row.innerHTML = `
                    <td><input type="checkbox" id=${beneficiary.ID_Utilisateur} name='id_checkboxes' value=${beneficiary.ID_Utilisateur}></td>
                    <td class="user-id">${beneficiary.ID_Utilisateur}</td>
                    <td>${beneficiary.Nom}</td>
                    <td>${beneficiary.Prenom}</td>
                    <td>${beneficiary.Genre}</td>
                    <td>${beneficiary.Email}</td>
                `;
            });
        })
        .catch(error => {
            console.error('Erreur lors de l\'affichage des volontaires :', error);
        });
}

function assignUsers(selectedUsers, service) {
    // Créer un tableau de promesses pour les requêtes assignUser
    const assignPromises = selectedUsers.map(user => assignUser(user, service));

    // Utiliser Promise.all() pour attendre que toutes les requêtes soient terminées
    return Promise.all(assignPromises)
        .then(() => {
            alert("Utilisateurs affectés au service");
            window.location.reload();
        })
        .catch(error => {
            console.error('Erreur lors de l\'assignation des utilisateurs :', error);
            alert('Erreur lors de l\'assignation des utilisateurs :', error.message);
        });
}

function assignUser(user, service) {
    apiUrl = 'http://localhost:8082/index.php/planning';

    const data = {
        "ID_Utilisateur": user,
        "ID_Service": service
    };

    var options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    // Retourner la promesse générée par fetch
    return fetch(apiUrl, options)
        .then(response => {
            if (!response.ok) {
                return response.text().then(errorMessage => {
                    throw new Error(errorMessage || 'Erreur inattendue.');
                });
            }
            return response.json(); // Analyser la réponse JSON
        })
        .catch(error => {
            // Intercepter et relancer l'erreur pour qu'elle soit gérée par Promise.all()
            throw error;
        });
}