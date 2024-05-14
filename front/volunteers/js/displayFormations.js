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

async function getUserFormations() {
    return fetch('http://localhost:8082/index.php/formations/my-formations/'+ getCookie('user_id'))
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

function displayFormations(formations,elementId){
    console.log("formations",formations);
    const formationContainer = document.getElementById(elementId);
    formations.forEach(formation => {
        console.log(formation);
        const section = document.createElement('button');
        section.classList.add('service-button');
        section.classList.add(elementId);
        section.id=formation.id;
        section.innerHTML = `
                                        <h2>${formation.titre}</h2>
<!--                                        <p>${formation.description}</p>-->
<!--                                    <button class="btn-inscription" id=${formation.id}>S'inscrire</button>-->
                    `;
        formationContainer.appendChild(section);
    })
    addFormationSeancesListeners();
}