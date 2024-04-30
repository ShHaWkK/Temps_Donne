let currentWeek = new Date();

function formatDate(date) {
    const options = {year: 'numeric', month: 'long', day: 'numeric'};
    return date.toLocaleDateString('fr-FR', options).replace(/\b\w{1}/g, function(letter) {
        return letter.toUpperCase();
    });
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
        startDate.setDate(startDate.getDate() + 1); // Next day
    }

    // Creating rows for each hour
    for (let hour = 6; hour < 23; hour++) {
        const row = table.insertRow();
        row.insertCell().textContent = hour + ":00 - " + (hour + 1) + ":00";

        // Creating cells for each day of the week
        for (let dayIndex = 0; dayIndex < 7; dayIndex++) {
            row.insertCell();
        }
    }
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