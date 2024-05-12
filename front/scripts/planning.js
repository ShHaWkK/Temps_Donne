let currentWeek = new Date();
let events;

function formatDate(date) {
    const options = {year: 'numeric', month: 'long', day: 'numeric'};
    return date.toLocaleDateString('fr-FR', options).replace(/\b\w{1}/g, function(letter) {
        return letter.toUpperCase();
    });
}

function formatWeek(currentWeek) {
    const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    const dayOfWeek = currentWeek.getDay(); // Jour de la semaine (0 - dimanche, 1 - lundi, ..., 6 - samedi)
    const diff = currentWeek.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1); // Nombre de jours à soustraire pour obtenir le lundi
    const mondayOfWeek = new Date(currentWeek.setDate(diff));

    const formattedDayOfWeek = days[mondayOfWeek.getDay()];
    const formattedMonth = months[mondayOfWeek.getMonth()];
    const formattedDayOfMonth = mondayOfWeek.getDate();
    const formattedYear = mondayOfWeek.getFullYear();

    return `${formattedDayOfWeek} ${formattedMonth} ${formattedDayOfMonth} ${formattedYear}`;
}

async function getUserPlanning() {
    try {
        const userId = getCookie('user_id');
        const url = 'http://localhost:8082/index.php/planning/' + userId + '/user';
        const response = await fetch(url);
        if (!response.ok) {
            alert('Erreur réseau');
        }

        return await response.json();
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        return [];
    }
}

// Fonction pour afficher les semaines dans le calendrier
function displayWeekTable() {
    console.log('displayWeekTable');
    // Displaying information
    const startDate = new Date(currentWeek);
    console.log(startDate);
    startDate.setDate(currentWeek.getDate() - currentWeek.getDay() + 1); // Monday of this week
    console.log(startDate);
    const endDate = new Date(startDate);
    console.log(endDate);
    endDate.setDate(endDate.getDate() + 6); // Sunday of this week
    console.log(endDate);
    document.getElementById("currentWeek").textContent = formatDate(startDate) + " - " + formatDate(endDate);

    // Displaying the planning calendar
    const days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    const table = document.getElementById("planningTable");

    // Remove existing rows from the table
    table.innerHTML = "";

    // Creating the table header
    const headerRow = table.insertRow();
    headerRow.insertCell().textContent = "Time";
    for (let i = 0; i < 7; i++) {
        const cell = headerRow.insertCell();
        cell.textContent = days[i] + " " + formatDate(new Date(startDate));
        startDate.setDate(startDate.getDate() + 1);
    }

    // Création des lignes pour chaque heure
    for (let hour = 0; hour < 23; hour++) {
        const row = table.insertRow();
        row.insertCell().textContent = hour + ":00 - " + (hour + 1) + ":00";

        // Création des cellules
        for (let dayIndex = 0; dayIndex < 7; dayIndex++) {
            row.insertCell();
        }
    }

    (async () => {
        events = await getUserPlanning();
        await displayEvents(events);
        //await displayEvents(events);
    })();
}
async function getEventData(serviceId) {
    try {
        const url = 'http://localhost:8082/index.php/services/' + serviceId;
        const response = await fetch(url);
        if (!response.ok) {
            alert('Erreur réseau');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        return [];
    }
}

async function displayEvents(events) {
    const table = document.getElementById("planningTable");

    for (const event of events) {
        const index = events.indexOf(event);
        let eventData = await getEventData(event.ID_Service);

        const startTime = parseInt(eventData.startTime.split(":")[0]);
        const endTime = parseInt(eventData.endTime.split(":")[0]);

        const startDate = new Date(eventData.Date);
        const eventDayIndex = startDate.getDay();
        const eventColumnIndex = (eventDayIndex === 0) ? 7 : eventDayIndex;

        const startRow = startTime + 1;
        const endRow = endTime + 1;

        let formattedCurrentWeek = formatWeek(currentWeek);

        // Filling the cells for the event
        for (let row = startRow; row <= endRow; row++) {
            const cell = table.rows[row].cells[eventColumnIndex];
            const formattedEventWeek = formatWeek(startDate); // Formatage de la semaine de l'événement
            if (formattedCurrentWeek === formattedEventWeek) {
                if (row === startRow) {
                    cell.textContent = eventData.Nom_du_service;
                    cell.rowSpan = endRow - startRow + 1;
                    cell.classList.add("planning-event");
                    cell.id = "planningEvent";
                    cell.dataset.eventIndex = index; // Ajouter l'attribut "data-event-index"
                } else {
                    cell.style.display = "none";
                }
            }
        }
    }
}

function displayNextWeek() {
    console.log("displayNextWeek",currentWeek);
    currentWeek.setDate(currentWeek.getDate() + 7);
    displayWeekTable();
}

function displayPreviousWeek() {
    console.log("displayPreviousWeek",currentWeek);
    currentWeek.setDate(currentWeek.getDate() - 7);
    displayWeekTable();
}

function displayCurrentWeek() {
    currentWeek = new Date(); // Réinitialisation à la date actuelle
    // const dayOfWeek = currentWeek.getDay(); // Jour de la semaine (0 - dimanche, 1 - lundi, ..., 6 - samedi)
    // const diff = currentWeek.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1); // Nombre de jours à soustraire pour obtenir le lundi
    // currentWeek.setDate(diff); // Réglez la date sur le lundi de cette semaine
    // console.log("currentWeek in displayCurrentWeek",currentWeek);
    displayWeekTable(); // Affichage du planning de la semaine actuelle
}

window.onload = async function () {
    try {
        await checkSession(); // Attend la vérification de la session
        const plannings = await getUserPlanning(); // Attend la récupération des données de planification
        displayWeekTable(plannings); // Affiche la table de planification avec les données récupérées
    } catch (error) {
        console.error('Erreur lors de la vérification de la session ou de la récupération des données:', error);
    }
}