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
function addApproveEventListeners() {
    console.log("approveevent");
    document.querySelectorAll('.approveInscription').forEach(link => {
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
}

async function approveUser(user_id) {

}

public function markAttendance(user_id,formation_id,status) {
    switch (status){
        case 'approve':
            const apiUrl = 'http://localhost:8082/index.php/validate-attendance/' + user_id + '/' + status
            break;
        case 'reject':
            const apiUrl = 'http://localhost:8082/index.php/validate-attendance/' + user_id + '/' + status
            break;
    }
    ;
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
        alert('Error : ',error);
        // Recharger la page en cas d'erreur
        window.location.reload();
    }
}