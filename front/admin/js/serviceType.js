async function getAllServiceType(){
    apiUrl='http://localhost:8082/index.php/services/type';
    return fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des types de service :', error);
            throw error;
        });
}

async function displayServiceTypes() {
    const serviceTypeSelector = document.getElementById('serviceTypeSelector');

    serviceTypeSelector.innerHTML = '';
    console.log("displayServiceTypes");

    try {
        const serviceTypes = await getAllServiceType(); // Attend la résolution de la promesse
        serviceTypes.forEach(serviceType => {
            const option = document.createElement('option');
            option.value = serviceType.ID_ServiceType;
            option.textContent = serviceType.Nom_Type_Service;
            serviceTypeSelector.appendChild(option);
        });
    } catch (error) {
        console.error('Une erreur s\'est produite lors de la récupération des types de service :', error);
    }
}