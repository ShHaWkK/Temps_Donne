<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Structure de la fenêtre modale -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="userDetails"></div> <!-- Contenu des détails de l'utilisateur -->
        <div id="availabilities"></div> <!-- Contenu des disponibilités -->
        <div id="skills"></div> <!-- Contenu des compétences -->
    </div>
</div>

<script>
    function addUserDetailsModalEventListeners() {
        console.log("wesh");
        document.querySelectorAll('.popup-button.userDetails').forEach(button => {
            button.addEventListener('click', function() {
                const userId = button.closest('tr').querySelector('input[name="id_buttons"]').value;
                console.log("click",userId);
                window.parent.postMessage({ type: 'openUserDetails', userId: userId }, '*');
            });
        });
    }
    // Fonction pour ouvrir la fenêtre modale lorsqu'on clique sur le bouton "Voir"
    document.querySelectorAll('.userDetails').forEach(button => {
        button.addEventListener('click', async function() {
            // Récupérer l'ID de l'utilisateur associé à ce bouton
            const userId = document.querySelector('input[name="id_buttons"]:checked').value;

            // Récupérer les détails de l'utilisateur
            const userDetailsResponse = await fetch(`http://localhost:8082/index.php/users/${userId}`);
            const userDetails = await userDetailsResponse.json();

            // Récupérer les disponibilités de l'utilisateur
            const availabilitiesResponse = await fetch(`http://localhost:8082/index.php/availabilities/${userId}`);
            const availabilityData = await availabilitiesResponse.json();

            // Convertir les disponibilités en un tableau de jours avec demi-journées
            const availabilityArray = [];
            for (const [key, value] of Object.entries(availabilityData)) {
                // Ignorer les clés non pertinentes
                if (key !== 'ID_Disponibilite' && key !== 'ID_Utilisateur') {
                    // Ajouter le jour et la demi-journée correspondante au tableau
                    if (value > 0) {
                        availabilityArray.push(`${key} - Demi-journée ${value}`);
                    }
                }
            }

            // Récupérer les compétences de l'utilisateur
            const skillsResponse = await fetch(`http://localhost:8082/index.php/skills/User/${userId}`);
            const skills = await skillsResponse.json();

            // Afficher les disponibilités de l'utilisateur dans la fenêtre modale
            const availabilitiesContainer = document.getElementById('availabilities');
            availabilitiesContainer.innerHTML = `
            <h2>Disponibilités</h2>
            <ul>
                ${availabilityArray.map(availability => `<li>${availability}</li>`).join('')}
            </ul>`;

            // Afficher les compétences de l'utilisateur dans la fenêtre modale
            const skillsContainer = document.getElementById('skills');
            skillsContainer.innerHTML = `
            <h2>Compétences</h2>
            <ul>
                ${skills.success.map(skill => `<li>${skill.Nom_Competence} - ${skill.Description}</li>`).join('')}
            </ul>`;

            // Afficher la fenêtre modale
            const modal = document.getElementById('myModal');
            modal.style.display = 'block';
        });
    });

    // Fermer la fenêtre modale lorsqu'on clique sur la croix
    document.querySelector('.close').addEventListener('click', function() {
        const modal = document.getElementById('myModal');
        modal.style.display = 'none';
    });

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('myModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Écouter les messages envoyés par l'iframe parent
    window.addEventListener('message', async function(event) {
        if (event.data.type === 'openUserDetails') {
            const userId = event.data.userId;
            console.log("userID1:", userId);
            // Récupérer les détails de l'utilisateur
            const userDetailsResponse = await fetch(`http://localhost:8082/index.php/users/${userId}`);
            const userDetails = await userDetailsResponse.json();

            // Récupérer les disponibilités de l'utilisateur
            const availabilitiesResponse = await fetch(`http://localhost:8082/index.php/availabilities/${userId}`);
            const availabilityData = await availabilitiesResponse.json();
            console.log(availabilityData);

            // Convertir les disponibilités en un texte formaté
            let availabilityText = '';
            Object.entries(availabilityData).forEach(([day, value]) => {
                if (day !== 'ID_Disponibilite' && day !== 'ID_Utilisateur' && day !== 'DEMI_JOURNEES' && value === 1) {
                    availabilityText += `${day.charAt(0).toUpperCase() + day.slice(1)}, `;
                }
            });
            availabilityText = availabilityText.slice(0, -2); // Supprimer la virgule et l'espace en trop à la fin

            // Récupérer les compétences de l'utilisateur
            const skillsResponse = await fetch(`http://localhost:8082/index.php/skills/User/${userId}`);
            const skills = await skillsResponse.json();

            // Afficher les détails de l'utilisateur dans la fenêtre modale
            const userDetailsContainer = document.getElementById('userDetails');
            userDetailsContainer.innerHTML =
                '<h2>Détails de l\'utilisateur</h2>' +
                '<p>ID Utilisateur: ' + userDetails.id_utilisateur + '</p>' +
                '<p>Nom: ' + userDetails.nom + '</p>' +
                '<p>Prénom: ' + userDetails.prenom + '</p>' +
                '<p>Genre: ' + userDetails.genre + '</p>' +
                '<p>Email: ' + userDetails.email + '</p>' +
                '<p>Adresse: ' + userDetails.adresse + '</p>' +
                '<p>Téléphone: ' + userDetails.telephone + '</p>' +
                '<p>Date de naissance: ' + userDetails.date_de_naissance + '</p>' +
                '<p>Nationalité: ' + userDetails.nationalite + '</p>' +
                '<p>Date d\'inscription: ' + userDetails.date_d_inscription + '</p>' +
                '<p>Statut: ' + userDetails.statut + '</p>' +
                '<p>Situation: ' + userDetails.situation + '</p>' +
                '<p>Besoins spécifiques: ' + userDetails.besoins_specifiques + '</p>' +
                '<p>Date de dernière connexion: ' + userDetails.date_derniere_connexion + '</p>' +
                '<p>Statut de connexion: ' + userDetails.statut_connexion + '</p>' +
                '<p>Emploi: ' + userDetails.emploi + '</p>' +
                '<p>Société: ' + userDetails.societe + '</p>' +
                '<p>Permis B: ' + userDetails.permis_b + '</p>' +
                '<p>Permis poids lourds: ' + userDetails.permis_poids_lourds + '</p>' +
                '<p>CACES: ' + userDetails.caces + '</p>' +
                '<p>Rôle: ' + userDetails.role + '</p>';

            // Afficher les disponibilités de l'utilisateur dans la fenêtre modale
            const availabilitiesContainer = document.getElementById('availabilities');
            availabilitiesContainer.innerHTML = `
            <h2>Disponibilités</h2>
            <p>${availabilityData.DEMI_JOURNEES} demi-journées par semaine les ${availabilityText}</p>`;

            // Afficher les compétences de l'utilisateur dans la fenêtre modale
            const skillsContainer = document.getElementById('skills');
            skillsContainer.innerHTML = `
            <h2>Compétences</h2>
            <ul>
                ${skills.success.map(skill => `<li>${skill.Nom_Competence} - ${skill.Description}</li>`).join('')}
            </ul>`;

            // Afficher la fenêtre modale
            const modal = document.getElementById('myModal');
            modal.style.display = 'block';
        }
    });
</script>

</body>
</html>