<?php
session_start();
require_once '../BDD/Connection.php';

// Vérifiez si l'ID utilisateur est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Un identifiant d'utilisateur est requis.";
    exit;
}

// Récupérez les informations de l'utilisateur
$userId = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM Utilisateurs WHERE ID_Utilisateur = :id");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}

// Ici, vous pouvez mettre en place le téléchargement du PDF si demandé
if (isset($_GET['download']) && $_GET['download'] == 'pdf') {
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Utilisateur</title>
    <!-- Inclure les liens CSS ici -->
</head>
<body>
    <div class="user-details">
        <h2>Détails de l'Utilisateur</h2>
        <!-- Afficher les détails de l'utilisateur ici -->
        <p>Nom: <?php echo $user['Nom']; ?></p>
        <p>Prénom: <?php echo $user['Prenom']; ?></p>
        <p>Email: <?php echo $user['Email']; ?></p>
        <p>Rôle: <?php echo $user['Role']; ?></p>
        <!-- ... autres détails ... -->

        <!-- Lien pour télécharger les détails en PDF -->
        <a href="user_details.php?id=<?php echo $userId; ?>&download=pdf" class="btn btn-primary">Télécharger en PDF</a>
    </div>
</body>
</html>
