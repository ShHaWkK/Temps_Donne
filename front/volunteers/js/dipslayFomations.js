async function getAllFormations() {
    return fetch('http://localhost:8082/index.php/formations')
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
dipslayFomations();
/*
let formations= await getAllFormations();
console.log(formations);

function displayFormations(formations) {
    //On vérifie si le paramètre est valide
    if (!Array.isArray(formations)) {
        console.error("Le paramètre 'services' doit être un tableau.");
        return;
    }

    const formationsContainer = document.getElementById('formations-container');

    formationsContainer.innerHTML = ``;
    formations.forEach(formation => {
        const section = document.createElement('section');
        section.classList.add('formation');
        section.innerHTML = `
                <h2>${formation.Titre}</h2>
                <p>${formation.Description}</p>
                <button class="btn-inscription" id=${formation.ID_Formation}>S'inscrire</button>
            `;
        formationsContainer.appendChild(section);
    });

    services.forEach(service => {
        const row = serviceTable.insertRow();
        // Appel de getServiceType qui renvoie une promesse
        getServiceType(service.ID_ServiceType)
            .then(serviceType => {
                // Une fois que la promesse est résolue, afficher les détails du service dans le tableau
                row.innerHTML = `
                <td> <input type="radio" id=${service.ID_Service} name='id_buttons' value=${service.ID_Service} ${firstService ? 'checked' : ''} /> </td>
                <td class="service-id">${service.ID_Service}</td>
                <td>${service.Nom_du_service}</td>
                <td>${serviceType}</td>
                <td>${service.Description}</td>
                <td>${service.Lieu}</td>
                <td>${service.Date}</td>
                <td>${service.startTime}</td>
                <td>${service.endTime}</td>
            `;
                firstService = false;
            })
            .catch(error => {
                // Gérer les erreurs si la promesse est rejetée
                console.error('Erreur lors de la récupération du type de service :', error);
            });
    });

}*/

function dipslayFomations(){
    // Faire une requête HTTP GET pour récupérer les données JSON des types de service
    fetch('http://localhost:8082/index.php/formations')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const formationContainer = document.getElementById('formations-container');
            data.success.forEach(formation => {
                const section = document.createElement('section');
                section.classList.add('formation');
                section.innerHTML = `
                                        <h2>${formation.Titre}</h2>
                                        <p>${formation.Description}</p>
                                    <button class="btn-inscription" id=${formation.ID_Formation}>S'inscrire</button>
                    `;
                formationContainer.appendChild(section);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des données JSON :', error));

}