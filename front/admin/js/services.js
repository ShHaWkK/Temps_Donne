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
            console.error('Erreur lors de la récupération des utilisateurs :', error);
            throw error;
        });
}
function displayServices(services) {
    const serviceTable = document.getElementById('serviceTable');

    serviceTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["ID_Service", "Nom", "Type", "Description", "Horaire", "Adresse","Date_Debut","Date_Fin","Détails"];

    const rowHeader = serviceTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    services.forEach(service => {
        const row = serviceTable.insertRow();
        row.innerHTML = `
                        <td class="service-id">${service.ID_Service}</td>
                        <td>${service.Nom_du_service}</td>
                        <td>${service.ID_ServiceType}</td>
                        <td>${service.Description}</td>
                        <td>${service.Horaire}</td>
                        <td>${service.Date_Debut}</td>
                        <td>${service.Date_Fin}</td>
                        <td>${service.Détails}</td>
                        <td><button class="popup-button serviceDetails"> Voir </button></td>
                    `;
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