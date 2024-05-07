// Faire une requête HTTP GET pour récupérer les données JSON des types de service$
let allServices = [];
let displayedServices =[];
function getAllServices() {
    return fetch('http://localhost:8082/index.php/services')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des services :', error);
            throw error;
        });
}

function getServiceType(serviceTypeID){
    const Url = 'http://localhost:8082/index.php/services/type/' + serviceTypeID;
    return fetch(Url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            // Retourner uniquement le nom du type de service
            return data.nom_Type_Service;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des types de services :', error);
            throw error;
        });
}

function displayServices(services) {
    const serviceTable = document.getElementById('serviceTable');

    serviceTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["","ID_Service", "Nom", "Type", "Description", "Adresse","Date","Heure début","Heure fin"];

    const rowHeader = serviceTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    services.forEach(service => {
        const row = serviceTable.insertRow();
        // Appel de getServiceType qui renvoie une promesse
        getServiceType(service.ID_ServiceType)
            .then(serviceType => {
                // Une fois que la promesse est résolue, afficher les détails du service dans le tableau
                row.innerHTML = `
                <td> <input type="radio" id=${service.ID_Service} name='id_buttons' value=${service.ID_Service} /> </td>
                <td class="service-id">${service.ID_Service}</td>
                <td>${service.Nom_du_service}</td>
                <td>${serviceType}</td>
                <td>${service.Description}</td>
                <td>${service.Lieu}</td>
                <td>${service.Date}</td>
                <td>${service.startTime}</td>
                <td>${service.endTime}</td>
            `;
            })
            .catch(error => {
                // Gérer les erreurs si la promesse est rejetée
                console.error('Erreur lors de la récupération du type de service :', error);
            });
    });

}

function addService(){

}

window.onload = function() {
    checkSession()
        .then(() => {
            return getAllServices();
        })
        .then(services => {
            allServices = services;
            displayedServices=services;
            displayServices(allServices);
            addAddServiceEvent();
        })
}