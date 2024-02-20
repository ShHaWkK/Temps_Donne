<?php
session_start();
require_once 'BDD/Connection.php';

// Vérification de la session admin
if (!isset($_SESSION['admin'])) {
    header('Location: Admin_login.php');
    exit();
}

function updateStatutValidation($id, $statut) {
    global $conn;
    $sql = "UPDATE Utilisateurs SET Statut_Validation = :statut WHERE ID_Utilisateur = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
    return $stmt->execute();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    switch ($action) {
        case 'valider':
            updateStatutValidation($id, 'Validé');
            break;
        case 'rejeter':
            updateStatutValidation($id, 'Rejeté');
            break;
        case 'attente':
            updateStatutValidation($id, 'En attente');
            break;
    }
}

$sql = "SELECT * FROM Utilisateurs WHERE Statut_Validation = 'En attente' OR Statut_Validation = 'Rejeté'";
$stmt = $conn->query($sql);
$demandes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Demandes d'Inscription</title>
    <!-- Inclure les fichiers de style ici -->
</head>
<body>
    <div class="container">
        <h1>Gestion des Demandes d'Inscription</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $demande): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($demande['Nom']); ?></td>
                        <td><?php echo htmlspecialchars($demande['Prenom']); ?></td>
                        <td><?php echo htmlspecialchars($demande['Email']); ?></td>
                        <td><?php echo htmlspecialchars($demande['Statut_Validation']); ?></td>
                        <td>
                            <a href="?action=valider&id=<?php echo $demande['ID_Utilisateur']; ?>" class="btn btn-success">Valider</a>
                            <a href="?action=rejeter&id=<?php echo $demande['ID_Utilisateur']; ?>" class="btn btn-danger">Rejeter</a>
                            <a href="?action=attente&id=<?php echo $demande['ID_Utilisateur']; ?>" class="btn btn-warning">Remettre en Attente</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
