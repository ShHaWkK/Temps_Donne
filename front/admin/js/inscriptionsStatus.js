/*
function addApproveEventListeners() {
    console.log("approveevent");
    document.querySelectorAll('.approve-link').forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();

            const userId = link.closest('tr').querySelector('.user-id').textContent.trim();

            try {
                await approveUser(userId);
            } catch (error) {
                console.error('Erreur lors de l\'approbation de l\'utilisateur:', error);
            }
        });
    });
}*/
/*
function addApproveEventListeners() {
    console.log("approveevent");
    document.querySelectorAll('.approve-link').forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();

            const userId = link.closest('tr').querySelector('.user-id').textContent.trim();

            try {
                await approveUser(userId);
            } catch (error) {
                console.error('Erreur lors de l\'approbation de l\'utilisateur:', error);
            }
        });
    });
}*/
function addStatusButtonEventListener() {
    const statusButtons = document.querySelectorAll('.statusButton');

    statusButtons.forEach(button => {
        button.addEventListener('click', async () => {
            // Récupérer l'ID du radioButton checked actuellement
            const checkedRadioButton = document.querySelector('input[name="id_buttons"]:checked');
            if (checkedRadioButton) {
                const ids = checkedRadioButton.id.split('-');
                const userId = ids[0];
                const formationId = ids[1];

                // Appeler la fonction setInscriptionStatus avec les IDs récupérés
                await setInscriptionStatus(userId, formationId, button.id);
            } else {
                console.error('Aucun radioButton n\'est coché');
            }
        });
    });
}

async function setInscriptionStatus(user_id, formation_id, status) {
    let apiUrl;
    switch (status) {
        case 'approveInscription':
            apiUrl = 'http://localhost:8082/index.php/formations/validate-attendance/' + user_id + '/' + formation_id;
            break;
        case 'rejectInscription':
            apiUrl = 'http://localhost:8082/index.php/formations/reject-attendance/' + user_id + '/' + formation_id;
            break;
        case 'holdInscription':
            apiUrl = 'http://localhost:8082/index.php/formations/putOnHold-attendance/' + user_id + '/' + formation_id;
            break;
    }
    console.log(apiUrl);

    const options = {
        method: 'PUT'
    };

    try {
        const response = await fetch(apiUrl, options);
        if (!response.ok) {
            throw new Error('Erreur lors de la requête à l\'API');
        }

        const data = await response.json();
        console.log('Réponse de l\'API :', data);
        alert(JSON.stringify(data));
        // Recharger la page après l'approbation de l'utilisateur
        window.location.reload();
    } catch (error) {
        console.error('Error :', error);
        alert('Error : ', error);
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}