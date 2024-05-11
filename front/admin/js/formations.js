function getAllFormations(){
    return fetch('http://localhost:8082/index.php/formations')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des formations :', error);
            throw error;
        });
}

function getAllInscriptions(){
    return fetch('http://localhost:8082/index.php/formations/inscriptions')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des formations :', error);
            throw error;
        });
}

function getAllSalles(){
    return fetch('http://localhost:8082/index.php/formations')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des formations :', error);
            throw error;
        });
}

function displayFormations(formations) {
    console.log("displayFormations",formations);
    //On vérifie si le paramètre est valide
    if (!Array.isArray(formations)) {
        console.error("Le paramètre 'formations' doit être un tableau.");
        return;
    }

    const formationTable = document.getElementById('formationTable');

    formationTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["", "Titre", "Description", "Date de début", "Date de fin"];

    const rowHeader = formationTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    let first = true;
    formations.forEach(formation => {
        const row = formationTable.insertRow();
        row.innerHTML = `
                        <td> <input type="radio" id=${formation.id} name='id_buttons-formations' value=${formation.id} ${first ? 'checked' : ''} /> </td>
                        <td >${formation.titre}</td>
                        <td>${formation.description}</td>
                        <td>${formation.dateDebut}</td>
                        <td>${formation.dateFin}</td>
<!--                        <td>${formation.Date_de_naissance}</td>-->
                    `;
        if (first === true) {
            selectedFormation = formation.ID_Utilisateur;
        }
        first = false;
    });
}

function displayInscriptions(inscriptions) {
    console.log("inscriptions",inscriptions);
    //On vérifie si le paramètre est valide
    if (!Array.isArray(inscriptions)) {
        console.error("Le paramètre 'inscriptions' doit être un tableau.");
        return;
    }

    const inscriptionTable = document.getElementById('inscriptionTable');

    inscriptionTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["", "Utilisateur", "Détails utilisateur", "Formation", "Détails Formation","Date_inscription","Statut"];

    const rowHeader = inscriptionTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    let first = true;
    inscriptions.forEach(inscription => {
        const row = inscriptionTable.insertRow();
        row.innerHTML = `
                        <td> <input type="radio" id=${inscription.ID_Utilisateur}-${inscription.ID_Formation} name='id_buttons' value=${inscription.ID_Utilisateur}- ${first ? 'checked' : ''} /> </td>
                        <td class="user-id">${inscription.ID_Utilisateur}</td>
                        <td><button class="popup-button userDetails" id=${inscription.ID_Utilisateur}> Voir </button></td>
                        <td class="formation-id">${inscription.ID_Formation}</td>
                        <td><button class="popup-button formationsDetails" id=${inscription.ID_Formation}> Voir </button></td>
                        <td>${inscription.Date_Inscription}</td>
                    `;
        
        const attendedCell = document.createElement('td');
        if (inscription.Attended == 0) {
            attendedCell.textContent = 'En attente';
        } else {
            attendedCell.textContent = 'Validée';
        }
        row.appendChild(attendedCell);

        if (first === true) {
            selectedFormation = inscription.ID_Utilisateur;
        }
        first = false;
    });
}