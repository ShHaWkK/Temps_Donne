<?php
session_start();
require_once 'BDD/Connection.php';

// Vérification de la session admin
if (!isset($_SESSION['admin'])) {
    header('Location: Admin_login.php');
    exit();
}

// Paramètres de pagination
$limit = 10; // Nombre de demandes par page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Paramètres de recherche et filtrage
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Construction de la requête de base
$sql = "SELECT * FROM Utilisateurs WHERE Nom LIKE :search OR Prenom LIKE :search OR Email LIKE :search";
if ($filter) {
    $sql .= " AND Statut_Validation = :filter";
}
$sql .= " LIMIT :start, :limit";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':search', '%' . $search . '%');
if ($filter) {
    $stmt->bindValue(':filter', $filter);
}
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$demandes = $stmt->fetchAll();

// Calcul du nombre total de pages
$sqlTotal = "SELECT COUNT(*) FROM Utilisateurs WHERE Nom LIKE :search OR Prenom LIKE :search OR Email LIKE :search";
if ($filter) {
    $sqlTotal .= " AND Statut_Validation = :filter";
}
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bindValue(':search', '%' . $search . '%');
if ($filter) {
    $stmtTotal->bindValue(':filter', $filter);
}
$stmtTotal->execute();
$totalDemandes = $stmtTotal->fetchColumn();
$totalPages = ceil($totalDemandes / $limit);

// Fonctions pour les actions
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

    // Ajouter la logique de confirmation ici

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

$sql = "SELECT * FROM Utilisateurs WHERE (Nom LIKE :search OR Prenom LIKE :search OR Email LIKE :search)";
$params = [
    ':search' => '%' . $search . '%'
];

if (!empty($filter)) {
    $sql .= " AND Statut_Validation = :filter";
    $params[':filter'] = $filter;
}

$sql .= " LIMIT :start, :limit";
$params[':start'] = $start;
$params[':limit'] = $limit;

$stmt = $conn->prepare($sql);
foreach ($params as $key => &$val) {
    $stmt->bindParam($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$stmt->execute();
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
