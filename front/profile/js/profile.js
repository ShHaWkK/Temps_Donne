// URL de l'API à interroger
userID=getCookie('user_id');
const apiUrl = 'http://localhost:8082/index.php/users/'+userID;

// Effectuer la requête HTTP GET avec fetch
fetch(apiUrl)
    .then(response => {
        // Vérifier si la requête a réussi
        if (!response.ok) {
            throw new Error('Erreur lors de la requête vers l\'API.');
        }
        // Retourner la réponse au format JSON
        return response.json();
    })
    .then(userData => {
        // Mettre les données utilisateur dans les champs appropriés
        document.getElementById('profile-name').textContent = userData.prenom + ' ' + userData.nom;
        document.getElementById('profile-email').textContent = userData.email;
        document.getElementById('updatable-profile-email').value = userData.email;
        document.getElementById('profile-firstname').value = userData.nom;
        document.getElementById('profile-lastname').value = userData.prenom;
        document.getElementById('profile-lastname').value = userData.prenom;
        document.getElementById('profile-telephone').value = userData.telephone;
        document.getElementById('profile-address').value = userData.adresse;
        document.getElementById('profile-birthdate').value = userData.date_de_naissance;
        document.getElementById('profile-languages').value = userData.langues;
        document.getElementById('profile-nationality').value = userData.nationalite;
        document.getElementById('profile-situation').value = userData.situation;
        // Assurez-vous d'adapter les IDs des éléments HTML aux données utilisateur
    })
    .catch(error => {
        console.error('Erreur:', error);
        // Gérer l'erreur
    });


// Fonction pour envoyer les données utilisateur mises à jour à l'API
// Fonction pour envoyer les données utilisateur mises à jour à l'API
async function updateUserProfile() {
    // Récupérer les valeurs des champs de formulaire
    const updatedProfileData = {};

    const nom = document.getElementById('profile-firstname').value.trim();
    if (nom !== '') updatedProfileData.Nom = nom;

    const prenom = document.getElementById('profile-lastname').value.trim();
    if (prenom !== '') updatedProfileData.Prenom = prenom;

    const telephone = document.getElementById('profile-telephone').value.trim();
    if (telephone !== '') updatedProfileData.Telephone = telephone;

    const adresse = document.getElementById('profile-address').value.trim();
    if (adresse !== '') updatedProfileData.Adresse = adresse;

    const nationalite = document.getElementById('profile-nationality').value.trim();
    if (nationalite !== '') updatedProfileData.Nationalite = nationalite;

    const email = document.getElementById('updatable-profile-email').value.trim();
    if (email !== '') updatedProfileData.Email = email;

    const dateDeNaissance = document.getElementById('profile-birthdate').value.trim();
    if (dateDeNaissance !== '') updatedProfileData.Date_de_naissance = dateDeNaissance;

    const situation = document.getElementById('profile-situation').value.trim();
    if (situation !== '') updatedProfileData.Situation = situation;

    // Envoyer les données mises à jour à l'API en tant que requête PUT
    fetch(apiUrl, {

        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedProfileData)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la mise à jour du profil.');
            }
            alert('Profil mis à jour avec succès !');
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour du profil.');
        });
}
