
<?php
require_once 'BDD/Connection.php';

$id_service = $_POST['service'];
$id_benevole = $_POST['benevole'];

$sql = "INSERT INTO Assignations (ID_Service, ID_Benevole) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_service, $id_benevole]);

header('Location: assign_volunteers.php'); // Redirigez vers la page d'assignation
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affectation des Bénévoles</title>
    <!-- Ajoutez vos liens CSS ici -->
</head>
<body>
    <form action="assign_volunteers.php" method="post">
        <label for="service">Service:</label>
        <select id="service" name="service">
            <?php
            $sql = "SELECT * FROM Services";
            $stmt = $conn->query($sql);
            $services = $stmt->fetchAll();
            foreach ($services as $service) {
                echo "<option value='{$service['ID_Service']}'>{$service['Nom_du_service']}</option>";
            }

            
            ?>
        </select>

        <label for="benevole">Bénévole:</label>
        <select id="benevole" name="benevole">
            <?php 
            $sql = "SELECT * FROM utilisateurs WHERE Role = 'Bénévole'";
            $stmt = $conn->query($sql);
            $benevoles = $stmt->fetchAll();
            foreach ($benevoles as $benevole) {
                echo "<option value='{$benevole['ID_Utilisateur']}'>{$benevole['Nom']} {$benevole['Prenom']}</option>";
            }
            
            ?>
        </select>

        <button type="submit">Assigner</button>
    </form>
</body>
</html>
