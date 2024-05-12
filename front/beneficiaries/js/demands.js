let selectedService;

async function addDemandListeners() {
    console.log("addDemandsListeners");

    // Sélectionner tous les boutons avec la classe 'service-button.my-formations'
    document.querySelectorAll('.service-button').forEach(button => {
        console.log(button);
        button.addEventListener('click', async function() {
            console.log("click",button.id)
            selectedService=button.id;
            // Désactiver tous les boutons ayant la classe active
            document.querySelectorAll('.service-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Ajouter la classe active uniquement au bouton cliqué
            button.classList.add('active');
        })
    })
}

async function displayServices(){
    fetch('http://localhost:8082/index.php/services/type')
        .then(response => response.json())
        .then(data => {
            console.log("On est dans le fetch",data);
            const serviceList = document.getElementById('service-list');
            data.forEach(service => {
                console.log(service);
                const button = document.createElement('button');
                button.classList.add('service-button');
                console.log(service.ID_ServiceType);
                button.id = service.ID_ServiceType
                button.innerHTML = `
                        <h3>${service.Nom_Type_Service}</h3>
                    `;
                serviceList.appendChild(button);
            });
            addDemandListeners();
        })
        .catch(error => console.error('Erreur lors de la récupération des données JSON :', error));
}

async function addDemand() {
    const userID = getCookie('user_id');
    const serviceID = selectedService;
    console.log("serviceId", serviceID);
    apiUrl = `http://localhost:8082/index.php/demand/${userID}/${serviceID}`;
    console.log(apiUrl);
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la récupération des données.');
            }
            return response.json();
        })
        .catch(error => {
            // Utiliser la variable error pour accéder à la réponse du serveur
            error.text().then(text => {
                console.error('Erreur lors de la récupération des données JSON :', error);
                console.log('Contenu de la réponse du serveur:', text);
            });
        });
}

window.onload = function() {
displayServices();}