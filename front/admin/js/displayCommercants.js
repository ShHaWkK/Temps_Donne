async function getAllCommercants(){
    return fetch('http://localhost:8082/index.php/partners')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des commerçants :', error);
            throw error;
        });
}

// Fonction pour filtrer les commerçants selon les critères donnés
function filterCommercants(commercants) {
    // Obtenir la date actuelle
    const currentDate = new Date();
    // Récupérer le jour de la semaine (0 pour dimanche, 1 pour lundi, ..., 6 pour samedi)
    const currentDayOfWeek = currentDate.getDay();

    // Filtrer les commerçants
    const filteredCommercants = commercants.filter(commercant => {
        // Vérifier si le contrat est en cours
        if (commercants.Contrat !== 'en_cours') {
            return false;
        }

        // Vérifier si c'est un jour de collecte pour le commerçant
        const currentDay = getDayOfWeekName(currentDayOfWeek);
        if (!commercants[currentDay]) {
            return false;
        }

        // Calculer le délai depuis la dernière collecte en jours
        const lastCollectDate = new Date(commercant.Date_Derniere_Collecte);
        const daysSinceLastCollect = Math.floor((currentDate - lastCollectDate) / (1000 * 60 * 60 * 24));

        // Vérifier si le délai depuis la dernière collecte est suffisant selon la fréquence de collecte du commerçant
        switch (commercant.Frequence_Collecte) {
            case 'quotidienne':
                return daysSinceLastCollect >= 1;
            case 'hebdomadaire':
                return daysSinceLastCollect >= 7;
            case 'mensuelle':
                return daysSinceLastCollect >= 30;
            default:
                return false;
        }
    });

    return filteredCommercants;
}

// Fonction utilitaire pour obtenir le nom du jour de la semaine à partir de son index (0 pour dimanche, 1 pour lundi, ..., 6 pour samedi)
function getDayOfWeekName(dayIndex) {
    const daysOfWeek = ['DIMANCHE', 'LUNDI', 'MARDI', 'MERCREDI', 'JEUDI', 'VENDREDI', 'SAMEDI'];
    return daysOfWeek[dayIndex];
}

function displayCommercants(commercants) {
    const commercantTable = document.getElementById('commercantTable');

    commercantTable.innerHTML = '';

    // On ajoute l'en-tête du tableau
    const tableHeader = ["Nom", "Adresse", "Frequence de collecte", "Date de dernière collecte",];

    const rowHeader = commercantTable.insertRow();
    rowHeader.classList.add("head");

    for (let i = 0; i < tableHeader.length; i++) {
        const th = document.createElement("th");
        th.textContent = tableHeader[i];
        rowHeader.appendChild(th);
    }

    commercants.forEach(commercant => {
        const row = commercantTable.insertRow();
        row.innerHTML = `
                        <td>${commercant.Nom}</td>
                        <td id=${commercant.ID_Commercant} name='commercant-address' data-address=${commercant.Adresse}>${commercant.Adresse}</td>
                        <td>${commercant.Frequence_Collecte}</td>
                        <td>${commercant.Date_Derniere_Collecte}</td>
                    `;
    });
}