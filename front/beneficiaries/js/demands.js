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
    console.log("userID", userID);

    const serviceID = selectedService;
    console.log("serviceId", serviceID);
    const apiUrl = `http://localhost:8082/index.php/demand/${userID}/${serviceID}`;
    console.log(apiUrl);

    const options = {
        method: 'POST'
    };

    try {
        const response = await fetch(apiUrl, options);
        const data = await response.json();
        console.log('Réponse de l\'API :', data);

        if (data.error) {
            const errorMessage = data.error;
            if (errorMessage.startsWith("SQLSTATE[23000]: Integrity constraint violation")) {
                console.log("Il est impossible de faire 2 demandes pour le même service");
                alert("Il est impossible de faire 2 demandes pour le même service");
            } else {
                console.log("Une autre erreur est survenue:", errorMessage);
                alert("Une autre erreur est survenue: " + errorMessage);
            }
        } else {
            console.log("Demande envoyée avec succès");
            alert("Demande envoyée avec succès");
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi des fichiers à l\'API :', error);
        alert('Erreur');
    }
}

window.onload = function() {
    checkSession()
        .then(() => {
            displayServices();
        })
}
