<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'utilisateur</title>
</head>
<body>

<div id="userDetails"></div>

<script>
    // Récupérer les données de l'utilisateur
    window.onload = async function() {
        const userId = <?php echo $_GET['userId']; ?>;

        // Récupérer les détails de l'utilisateur
        const userDetailsResponse = await fetch(`http://localhost:8082/index.php/users/${userId}`);
        const userDetails = await userDetailsResponse.json();

        // Récupérer les disponibilités de l'utilisateur
        const availabilitiesResponse = await fetch(`http://localhost:8082/index.php/availabilities/${userId}`);
        const availabilities = await availabilitiesResponse.json();

        // Récupérer les compétences de l'utilisateur
        const skillsResponse = await fetch(`http://localhost:8082/index.php/skills/User/${userId}`);
        const skills = await skillsResponse.json();

        // Afficher les détails de l'utilisateur
        const userDetailsContainer = document.getElementById('userDetails');
        userDetailsContainer.innerHTML = `
            <h2>Détails de l'utilisateur</h2>
            <p>ID Utilisateur: ${userDetails.id_utilisateur}</p>
            <p>Nom: ${userDetails.nom}</p>
            <p>Prénom: ${userDetails.prenom}</p>
            <p>Genre: ${userDetails.genre}</p>
            <p>Email: ${userDetails.email}</p>

            <h2>Disponibilités</h2>
            <ul>
                ${availabilities.map(availability => `<li>${availability}</li>`).join('')}
            </ul>

            <h2>Compétences</h2>
            <ul>
                ${skills.success.map(skill => `<li>${skill.Nom_Competence} - ${skill.Description}</li>`).join('')}
            </ul>
        `;
    };
        // Fonction pour ouvrir la fenêtre modale
        function openModal() {
        document.getElementById('myModal').style.display = 'block';
    }

        // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
        window.onclick = function(event) {
        var modal = document.getElementById('myModal');
        if (event.target === modal) {
        modal.style.display = "none";
    }
    }

        // Écouter les messages envoyés par l'iframe parent
        window.addEventListener('message', function(event) {
        if (event.data.type === 'openUserDetails') {
        const userId = event.data.userId;
        openModal(userId);
    }
    });
</script>

</body>
</html>