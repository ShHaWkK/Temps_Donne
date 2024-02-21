<?php
include '../BDD/Connection.php';


// Traitement des actions
if(isset($_GET['action']) && isset($_GET['service_id'])) {
    $action = $_GET['action'];
    $serviceId = $_GET['service_id'];

    switch($action) {
        case 'demande':
            envoyerDemande($serviceId);
            break;
        case 'pause':
            mettreEnPause($serviceId);
            break;
        case 'supprimer':
            supprimerService($serviceId);
            break;
        default:
            // Gérer les actions inconnues
            break;
    }
}

// Récupérer la liste des services depuis la base de données
$sql = "SELECT * FROM Services";
$stmt = $conn->query($sql);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #00334A;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #00334A;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            color: #00334A;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
        }

        .actions button {
            margin-right: 5px;
            padding: 8px 12px;
            background-color: #00334A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .actions button:hover {
            background-color: #001F29;
        }

    </style>
</head>
<body>
    <h2>Liste des Services</h2>
    <table>
        <thead>
            <tr>
                <th>Nom du Service</th>
                <th>Description</th>
                <th>Horaire</th>
                <th>Lieu</th>
                <th>Type de Service</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Utilisateur Assigné</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
            <tr>
                <td><?php echo $service['Nom_du_service']; ?></td>
                <td><?php echo $service['Description']; ?></td>
                <td><?php echo $service['Horaire']; ?></td>
                <td><?php echo $service['Lieu']; ?></td>
                <td><?php echo $service['Type_Service']; ?></td>
                <td><?php echo $service['Date_Debut']; ?></td>
                <td><?php echo $service['Date_Fin']; ?></td>
                <td><?php echo isset($service['Nom']) ? $service['Nom'] . ' ' . $service['Prenom'] : 'Non assigné'; ?></td>
                <td class="actions">
                    <!-- Boutons d'action -->
                    <button onclick="envoyerDemande(<?php echo $service['ID_Service']; ?>)">Envoyer Demande</button>
                    <button onclick="mettreEnPause(<?php echo $service['ID_Service']; ?>)">Mettre en Pause</button>
                    <button onclick="supprimerService(<?php echo $service['ID_Service']; ?>)">Supprimer</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function envoyerDemande(serviceId) {
            // Envoyer une requête POST au serveur pour envoyer une demande
            fetch(`service_list.php?action=demande&service_id=${serviceId}`, {
                method: 'POST'
            })
            .then(response => {
                // Actualiser la page après avoir traité la demande
                location.reload();
            })
            .catch(error => {
                console.error('Une erreur s\'est produite:', error);
            });
        }

        function mettreEnPause(serviceId) {
            // Envoyer une requête POST au serveur pour mettre en pause le service
            fetch(`service_list.php?action=pause&service_id=${serviceId}`, {
                method: 'POST'
            })
            .then(response => {
                // Actualiser la page après avoir traité la demande
                location.reload();
            })
            .catch(error => {
                console.error('Une erreur s\'est produite:', error);
            });
        }

        function supprimerService(serviceId) {
            // Envoyer une requête POST au serveur pour supprimer le service
            fetch(`service_list.php?action=supprimer&service_id=${serviceId}`, {
                method: 'POST'
            })
            .then(response => {
                // Actualiser la page après avoir traité la demande
                location.reload();
            })
            .catch(error => {
                console.error('Une erreur s\'est produite:', error);
            });
        }
    </script>
</body>
</html>

