// Récupérer les éléments du DOM
var modal = document.getElementById('eventModal');
var closeBtn = document.getElementsByClassName('close')[0];
var eventName = document.getElementById('eventName');
var eventDescription = document.getElementById('eventDescription');
var eventDate = document.getElementById('eventDate');
var eventStartTime = document.getElementById('eventStartTime');
var eventEndTime = document.getElementById('eventEndTime');

// Lorsque l'utilisateur clique sur une cellule d'événement
document.getElementById('planningTable').addEventListener('click', function(event) {
    // Vérifier si la cellule cliquée a l'ID "planningEvent"
    if (event.target.id === 'planningEvent') {
        // Récupérer les données de l'événement à partir de l'attribut "data-event-index" de la cellule
        const eventIndex = event.target.dataset.eventIndex;
        console.log("eventIndex",eventIndex);
        const eventData = events[eventIndex];

        // Afficher les détails de l'événement dans la fenêtre modale
        eventName.textContent = eventData.activity;
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