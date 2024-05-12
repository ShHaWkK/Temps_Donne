<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
?>

<head>
    <title><h3>Profil Page</h3></title>
    <link rel="stylesheet" href="./css/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

    <div class="main-container">
    <h1>Profil</h1>


    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img id="profile-img" class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span id="profile-name" class="font-weight-bold"></span>
                <span id="profile-email" class="text-black-50"></span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="text-right">Informations du profil</h2>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Nom</label><input id="profile-firstname" type="text" class="form-control" placeholder="first name"></div>
                    <div class="col-md-12"><label class="labels">Prénom</label><input id="profile-lastname" type="text" class="form-control" placeholder="surname"></div>
                    <div class="col-md-12"><label class="labels">Numéro de téléphone</label><input id="profile-telephone" type="text" class="form-control" placeholder="enter phone number"></div>
                    <div class="col-md-12"><label class="labels">Adresse</label><input id="profile-address" type="text" class="form-control" placeholder="enter address"></div>
                    <div class="col-md-12"><label class="labels">Nationalité</label><input id="profile-nationality" type="text" class="form-control" placeholder="enter nationality"></div>
<!--                    <div class="col-md-12"><label class="labels">Mot de passe</label><input id="profile-password" type="password" class="form-control" placeholder="enter new password"></div>-->
                    <div class="col-md-12"><label class="labels">Email </label><input type="text" class="form-control" id="updatable-profile-email" placeholder="enter email" ></div>
                    <div class="col-md-12"><label class="labels">Date de naissance</label><input id="profile-birthdate" type="date" class="form-control" placeholder="enter birthdate"></div>
                    <div class="col-md-12"><label class="labels">Situation</label><input type="text" id="profile-situation" class="form-control" placeholder="enter situation"></div>
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button" onclick="updateUserProfile()">Modifier le profil</button></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">


            </div>
        </div>
    </div>
    </div>
<script src="../scripts/getCookie.js"></script>
<script>
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
                window.location.reload();
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la mise à jour du profil.');
            });
    }

</script>
</body>
</html>