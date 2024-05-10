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

function displayFormations(formations){
    console.log("formations",formations);
    const formationContainer = document.getElementById('formations-container');
    formations.forEach(formation => {
        console.log(formation);
        const section = document.createElement('button');
        section.classList.add('service-button');
        section.id=formation.id;
        section.innerHTML = `
                                        <h2>${formation.titre}</h2>
<!--                                        <p>${formation.description}</p>-->
<!--                                    <button class="btn-inscription" id=${formation.id}>S'inscrire</button>-->
                    `;
        formationContainer.appendChild(section);
    })
}