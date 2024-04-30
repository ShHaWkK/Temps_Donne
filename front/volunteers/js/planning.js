let currentWeek = new Date();

// Exemple d'utilisation :
const events = [
    {
        "ID_Planning": 1,
        "ID_Utilisateur": 1,
        "Date": "2024-05-01",
        "Description": "Maraude",
        "activity": "Maraude",
        "startTime": "08:30",
        "endTime": "09:45"
    },
    {
        "ID_Planning": 2,
        "ID_Utilisateur": 1,
        "Date": "2024-05-02",
        "Description": "Visite",
        "activity": "Visite",
        "startTime": "14:00",
        "endTime": "16:00"
    },
    {
        "ID_Planning": 3,
        "ID_Utilisateur": 1,
        "Date": "2024-05-10",
        "Description": "Cours",
        "activity": "Cours",
        "startTime": "12:00",
        "endTime": "16:00"
    }
];

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

function displayWeekTable() {
    // Displaying information
    const startDate = new Date(currentWeek);
    startDate.setDate(currentWeek.getDate() - currentWeek.getDay() + 1); // Monday of this week
    const endDate = new Date(startDate);
    endDate.setDate(endDate.getDate() + 6); // Sunday of this week
    document.getElementById("currentWeek").textContent = formatDate(startDate) + " - " + formatDate(endDate);

    // Displaying the planning calendar
    const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
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

    displayEvents(events);
}

function displayEvents(events) {
    const table = document.getElementById("planningTable");

    events.forEach(event => {
        const startTime = parseInt(event.startTime.split(":")[0]);
        const endTime = parseInt(event.endTime.split(":")[0]);

        const startDate = new Date(event.Date);
        const eventDayIndex = startDate.getDay();
        const eventColumnIndex = (eventDayIndex === 0) ? 7 : eventDayIndex; // Si c'est dimanche, on met 7 pour obtenir la dernière colonne

        const startRow = startTime + 1;
        const endRow = endTime + 1;

        let formattedCurrentWeek = formatWeek(currentWeek);
        // Filling the cells for the event
        for (let row = startRow; row <= endRow; row++) {
            const cell = table.rows[row].cells[eventColumnIndex];
            const formattedEventWeek = formatWeek(startDate); // Formatage de la semaine de l'événement
            if (formattedCurrentWeek === formattedEventWeek) {
                if (row === startRow) {
                    cell.textContent = event.activity;
                    cell.rowSpan = endRow - startRow + 1;
                    cell.classList.add("planning-event");
                } else {
                    cell.style.display = "none";
                }
            }
        }
    });
}

function displayNextWeek() {
    currentWeek.setDate(currentWeek.getDate() + 7);
    displayWeekTable();
}

function displayPreviousWeek() {
    currentWeek.setDate(currentWeek.getDate() - 7);
    displayWeekTable();
}

function displayCurrentWeek() {
    currentWeek = new Date();
    displayWeekTable();
}

window.onload = function() {
    displayWeekTable();
}