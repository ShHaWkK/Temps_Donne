<?php
include 'BDD/Connection.php';

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_service = $_POST['nom_service'];
    $description = $_POST['description'];
    $horaire = $_POST['horaire'];
    $lieu = $_POST['lieu'];
    $type_service = $_POST['type_service'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $sql = "INSERT INTO Services (Nom_du_service, Description, Horaire, Lieu, ID_Administrateur, NFC_Tag_Data, Type_Service, Date_Debut, Date_Fin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom_service, $description, $horaire, $lieu, $id_administrateur, $nfc_tag_data, $type_service, $date_debut, $date_fin]);

    // Redirection après l'ajout du service
    header('Location: service_list.php'); // Modifier selon votre besoin
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 300px;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            border: none;
            background-color: #82CFD8;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Ajouter un Nouveau Service</h2>
    <form action="add_service.php" method="post">
        <label for="nom_service">Nom du Service:</label>
        <input type="text" id="nom_service" name="nom_service" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <label for="horaire">Horaire:</label>
        <input type="time" id="horaire" name="horaire">

        <label for="lieu">Lieu:</label>
        <input type="text" id="lieu" name="lieu">

        <label for="type_service">Type de Service:</label>
        <input type="text" id="type_service" name="type_service">

        <label for="date_debut">Date de Début:</label>
        <input type="date" id="date_debut" name="date_debut">

        <label for="date_fin">Date de Fin:</label>
        <input type="date" id="date_fin" name="date_fin">

        <button type="submit">Ajouter le Service</button>
    </form>
</body>
</html>
