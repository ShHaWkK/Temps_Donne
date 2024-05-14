let selectedDemand;

function getAllDemands() {
    console.log("getAllDemands");
    return fetch('http://localhost:8082/index.php/demand')
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

async function getServiceType(typeId){
    try {
        const url = 'http://localhost:8082/index.php/services/type/' + typeId;
        const response = await fetch(url);
        if (!response.ok) {
            alert('Erreur réseau');
        }
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        return [];
    }
}

async function displayDemands(demands) {
    console.log("we are here");
    //On vérifie si le paramètre est valide
    if (!Array.isArray(demands)) {
        console.error("Le paramètre 'demands' doit être un tableau.");
        return;
    }

    const demandsTable = document.getElementById('demandsTable');

    demandsTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["", "Utilisateur", "Type de Service","Statut", "Détails"];

    const rowHeader = demandsTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    let firstDemand = true;
    for (const demand of demands) {
        const row = demandsTable.insertRow();
        let user = await getUserByID(demand.ID_Utilisateur);
        let serviceType = await getServiceType(demand.ID_ServiceType);
        row.innerHTML = `
                        <input type="radio" id="${demand.ID_Utilisateur}-${demand.ID_ServiceType}" name="id_buttons_user_demand" value="${demand.ID_Utilisateur}-${demand.ID_ServiceType}" ${firstDemand ? 'checked' : ''} />
                        <td>${user.nom} ${user.prenom}</td>
                        <td>${serviceType.nom_Type_Service}</td>
                        <td>${demand.Statut}</td>
                        <td><button class="popup-button userDetails"> Voir </button></td>
                    `;
        if (firstDemand === true) {
            selectedDemand = user.ID_Utilisateur + '-' + demand.ID_ServiceType;
        }
        firstDemand = false;
    }
}

async function approveDemand(user_id, serviceType_id) {
    const apiUrl = `http://localhost:8082/index.php/demand/approve/${user_id}/${serviceType_id}`;
    const options = {
        method: 'PUT'
    };

    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            throw new Error('Erreur lors de la requête à l\'API');
        }

        const data = await response.json();
        console.log('Réponse de l\'API :', data);
        alert(JSON.stringify(data));
        // Recharger la page après l'approbation de l'utilisateur
        window.location.reload();
    } catch (error) {
        console.error('Erreur :', error);
        alert('Erreur : ' + error.message);
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}

async function putOnHoldDemand(user_id, serviceType_id){
    const apiUrl = `http://localhost:8082/index.php/demand/hold/${user_id}/${serviceType_id}`;
    const options = {
        method: 'PUT'
    };

    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            throw new Error('Erreur lors de la requête à l\'API');
        }

        const data = await response.json();
        console.log('Réponse de l\'API :', data);
        alert(JSON.stringify(data));
        // Recharger la page après l'approbation de l'utilisateur
        window.location.reload();
    } catch (error) {
        console.error('Erreur :', error);
        alert('Erreur : ' + error.message);
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}

async function rejectDemand(user_id, serviceType_id){
    const apiUrl = `http://localhost:8082/index.php/demand/reject/${user_id}/${serviceType_id}`;
    const options = {
        method: 'PUT'
    };

    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            throw new Error('Erreur lors de la requête à l\'API');
        }

        const data = await response.json();
        console.log('Réponse de l\'API :', data);
        alert(JSON.stringify(data));
        // Recharger la page après l'approbation de l'utilisateur
        window.location.reload();
    } catch (error) {
        console.error('Erreur :', error);
        alert('Erreur : ' + error.message);
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}

// Ajouter les événements aux boutons de sélection des demandes
function addSelectedDemandButtonEvent(){
    const buttons = document.getElementsByName('id_buttons_user_demand');

// Parcourir tous les boutons radio et ajouter un écouteur d'événement de changement à chacun
    buttons.forEach(button => {
        button.addEventListener('change', function() {
            // Vérifier si le bouton est coché
            if (this.checked) {
                // Mettre à jour la valeur sélectionnée avec la value du bouton coché
                selectedDemand = this.value;
                console.log("le bouton : ",this)
                console.log("La valeur sélectionnée est : ", selectedDemand);
            }
        });
    });
}

