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
async function filterCommercants(commercants, warehouseAddress) {
    const currentDate = new Date();
    const currentDayOfWeek = currentDate.getDay();
    const filteredCommercants = [];

    for (const commercant of commercants) {
        if (commercant.Contrat !== 'en_cours') {
            continue;
        }

        const isCommercantInRadius = await checkUserInRadius(commercant.Adresse, warehouseAddress, 50);
        console.log("is commercant in radius", isCommercantInRadius);

        if (!isCommercantInRadius) {
            continue;
        }

        const currentDay = getDayOfWeekName(currentDayOfWeek);
        if (!commercant[currentDay]) {
            continue;
        }

        const lastCollectDate = new Date(commercant.Date_Derniere_Collecte);
        const daysSinceLastCollect = Math.floor((currentDate - lastCollectDate) / (1000 * 60 * 60 * 24));

        switch (commercant.Frequence_Collecte) {
            case 'quotidienne':
                if (daysSinceLastCollect >= 1) {
                    filteredCommercants.push(commercant);
                }
                break;
            case 'hebdomadaire':
                if (daysSinceLastCollect >= 7) {
                    filteredCommercants.push(commercant);
                }
                break;
            case 'mensuelle':
                if (daysSinceLastCollect >= 30) {
                    filteredCommercants.push(commercant);
                }
                break;
        }
    }

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