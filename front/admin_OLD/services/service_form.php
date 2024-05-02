<?php

include_once 'BDD/Connection.php';

$id_service = $_POST['id_service'] ?? null;
$nom_service = $_POST['nom_service'];
$description_service = $_POST['description_service'];


if ($id_service) {
    $sql = "UPDATE Services SET Nom_du_service=?, Description=? WHERE ID_Service=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom_service, $description_service, $id_service]);
} else {
    // Ajout d'un nouveau service
    $sql = "INSERT INTO Services (Nom_du_service, Description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom_service, $description_service]);
}

header('Location: service_list.php'); // Redirigez vers la liste des services après l'opération
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Services</title>
    <!-- Ajoutez vos liens CSS ici -->
</head>
<body>
    <form action="service_form.php" method="post">
        <input type="hidden" name="id_service" value="<?php // Mettez ici l'ID du service pour la modification ?>">

        <label for="nom_service">Nom du Service:</label>
        <input type="text" id="nom_service" name="nom_service" required>

        <label for="description_service">Description:</label>
        <textarea id="description_service" name="description_service"></textarea>

        <!-- Ajoutez d'autres champs ici selon les besoins -->

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
