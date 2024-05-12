// Récupérer les éléments du DOM
var modal = document.getElementById('eventModal');
var closeBtn = document.getElementsByClassName('close')[0];
var eventName = document.getElementById('eventName');
var eventType = document.getElementById('eventType');
var eventDescription = document.getElementById('eventDescription');
var eventDate = document.getElementById('eventDate');
var eventStartTime = document.getElementById('eventStartTime');
var eventEndTime = document.getElementById('eventEndTime');


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

// Lorsque l'utilisateur clique sur une cellule d'événement
document.getElementById('planningTable').addEventListener('click', async function (event) {
    // Vérifier si la cellule cliquée a l'ID "planningEvent"
    if (event.target.id === 'planningEvent') {
        // Récupérer les données de l'événement à partir de l'attribut "data-event-index" de la cellule
        const eventIndex = event.target.dataset.eventIndex;
        console.log("eventIndex", eventIndex);
        // console.log("eventIndex",eventIndex);
        const planning = events[eventIndex];
        console.log("eventData", planning);

        let eventData = await getEventData(planning.ID_Service);
        let serviceType = await getServiceType(eventData.ID_ServiceType);
        console.log(serviceType);

        // Afficher les détails de l'événement dans la fenêtre modale
        eventName.textContent = eventData.Nom_du_service;
        eventType.textContent = serviceType.nom_Type_Service;
        eventDescription.textContent = eventData.Description;
        eventDate.textContent = eventData.Date;
        eventStartTime.textContent = eventData.startTime;
        eventEndTime.textContent = eventData.endTime;

        modal.style.display = 'block'; // Afficher la fenêtre modale
    }
});

// Lorsque l'utilisateur clique sur le bouton "fermer"
closeBtn.onclick = function() {
    modal.style.display = 'none'; // Masquer la fenêtre modale
}

// Lorsque l'utilisateur clique en dehors de la fenêtre modale, elle se ferme
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = 'none'; // Masquer la fenêtre modale
    }
}