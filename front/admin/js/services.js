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
    console.log("serviceTypeID",serviceTypeID);
    const Url = 'http://localhost:8082/index.php/services/type/' + serviceTypeID;
    console.log(Url);
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
    const tableHeader = ["ID_Service", "Nom", "Type", "Description", "Horaire", "Adresse","Date_Debut","Date_Fin","Détails","Action"];

    const rowHeader = serviceTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    services.forEach(service => {
        const row = serviceTable.insertRow();
        console.log("service.Nom", service.ID_ServiceType);

        // Appel de getServiceType qui renvoie une promesse
        getServiceType(service.ID_ServiceType)
            .then(serviceType => {
                // Une fois que la promesse est résolue, afficher les détails du service dans le tableau
                row.innerHTML = `
                <td class="service-id">${service.ID_Service}</td>
                <td>${service.Nom_du_service}</td>
                <td>${serviceType}</td>
                <td>${service.Description}</td>
                <td>${service.Horaire}</td>
                <td>${service.startTime}</td>
                <td>${service.endTime}</td>
                <td>${service.Détails}</td>
                <td><button class="popup-button serviceDetails">Voir</button></td>
                <td><a href='#' class="assignUser-link">Affecter</a>
            `;
            })
            .catch(error => {
                // Gérer les erreurs si la promesse est rejetée
                console.error('Erreur lors de la récupération du type de service :', error);
            });
    });

}

window.onload = function() {
    checkSession()
        .then(() => {
            return getAllServices();
        })
        .then(services => {
            allServices = services;
            displayedServices=services;
            console.log(allServices);
            displayServices(allServices);
        })
}