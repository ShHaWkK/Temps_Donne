<?php
session_start();
require_once '../BDD/Connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin'])) {
    header('Location: Admin_login.php');
    exit();
}

// Traitement du formulaire
if (isset($_POST['add_user'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash du mot de passe
    $role_id = $_POST['role']; // ID du rôle sélectionné


    // Insertion dans la base de données
    try {
        $query = "INSERT INTO Utilisateurs (Nom, Prenom, Email, Mot_de_passe) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nom, $prenom, $email, $password]);

        // Récupérer le dernier ID inséré
        $user_id = $conn->lastInsertId();

        // Assigner un rôle à l'utilisateur
        $query = "INSERT INTO UtilisateursRoles (ID_Utilisateur, ID_Role) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id, $role_id]);

        // Redirection ou message de succès
        echo "Utilisateur ajouté avec succès !";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// Récupérer tous les rôles disponibles
$query = "SELECT * FROM Roles";
$stmt = $conn->query($query);
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <!-- Insérez ici les liens vers vos feuilles de style -->
</head>
<body>
    <form method="POST" action="admin_add_user.php">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="role">Rôle:</label>
        <select id="role" name="role">
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['ID_Role']; ?>"><?php echo $role['Nom_Role']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" name="add_user">Ajouter l'utilisateur</button>
    </form>
</body>
</html>
