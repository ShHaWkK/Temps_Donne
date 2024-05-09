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

//----------------------------- On sélectionne uniquement les camions prêts à partir (ni en service ni en panne)
function getAvailableTrucks(trucks,id_entrepot) {
     return trucks.filter(truck => {
        return truck.Statut == "En service" && truck.ID_Entrepot == id_entrepot;
    });
}

function displayTrucks(id_entrepot) {
    const truckList = document.getElementById('truckList');

    console.log(allTrucks);
    let availableTrucks = getAvailableTrucks(allTrucks,id_entrepot);
    truckList.innerHTML = '';
    console.log("availaibleTrucks",availableTrucks);

    try {
        availableTrucks.forEach(truck => {
            const option = document.createElement('option');
            option.value = truck.ID_Camion;
            option.textContent = truck.Modele + ' ' + truck.Immatriculation;
            truckList.appendChild(option);
        });
    } catch (error) {
        console.error('Une erreur s\'est produite lors de la récupération des types de service :', error);
    }
}