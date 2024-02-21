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

$sql = "SELECT * FROM Utilisateurs WHERE Statut_Validation = 'En attente'";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "Nom: " . $row["Nom"]. " - Email: " . $row["Email"]. " <a href='valider_benevole.php?id=".$row["ID_Utilisateur"]."'>Valider</a> <a href='rejeter_benevole.php?id=".$row["ID_Utilisateur"]."'>Rejeter</a><br>";
    }
} else {
    echo "Aucun bénévole en attente de validation.";
}
?>
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Demandes d'Inscription</title>
<style>

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        line-height: 1.6;
    }

    .container {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }

    .table th, .table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .table th {
        background-color: #f8f8f8;
        color: #333;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        border: none;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-warning {
        background-color: #ffc107;
    }

    .pagination {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }

    .pagination a {
        padding: 8px 16px;
        margin: 0 5px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .pagination a.active {
        background-color: #0056b3;
        color: #fff;
        border: 1px solid #0056b3;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group input[type="text"], .form-group select {
        padding: 10px;
        width: 200px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-right: 10px;
    }

    .form-group button {
        padding: 10px 20px;
        border: none;
        background-color: #28a745;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-group button:hover {
        background-color: #218838;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Gestion des Demandes d'Inscription</h1>
        
       <!-- Formulaire de recherche et filtrage -->
        <form action="" method="get">
            <div class="form-group">
                <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Rechercher par nom, prénom ou email">
                <button type="submit">Rechercher</button>
            </div>
            <div class="form-group">
                <select name="filter">
                    <option value="">Tous les statuts</option>
                    <option value="En attente" <?php echo $filter == 'En attente' ? 'selected' : ''; ?>>En attente</option>
                    <option value="Validé" <?php echo $filter == 'Validé' ? 'selected' : ''; ?>>Validé</option>
                    <option value="Rejeté" <?php echo $filter == 'Rejeté' ? 'selected' : ''; ?>>Rejeté</option>
                </select>
                <button type="submit">Filtrer</button>
            </div>
        </form>



        <!-- Tableau des demandes -->
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
                            <a href="?action=valider&id=<?php echo $demande['ID_Utilisateur']; ?>&page=<?php echo $page; ?>" class="btn btn-success" onclick="return confirm('Valider cette demande ?');">Valider</a>
                            <a href="?action=rejeter&id=<?php echo $demande['ID_Utilisateur']; ?>&page=<?php echo $page; ?>" class="btn btn-danger" onclick="return confirm('Rejeter cette demande ?');">Rejeter</a>
                            <a href="?action=attente&id=<?php echo $demande['ID_Utilisateur']; ?>&page=<?php echo $page; ?>" class="btn btn-warning">Remettre en Attente</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&filter=<?php echo $filter; ?>" class="page-link <?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>
