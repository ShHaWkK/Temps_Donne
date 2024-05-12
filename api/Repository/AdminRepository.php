<?php
// file : api/Repository/AdminRepository.php
require_once './Models/AdminModel.php';
require_once './Repository/BDD.php';

class AdminRepository {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function findAll() {
        $sql = "SELECT u.* FROM Utilisateurs u INNER JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur INNER JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE r.Nom_Role = 'Administrateur'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $admins = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $admin = new AdminModel($row);
            array_push($admins, $admin);
        }
        return $admins;
    }

    public function findById($id) {
        $sql = "SELECT u.* FROM Utilisateurs u INNER JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur INNER JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE r.Nom_Role = 'Administrateur' AND u.ID_Utilisateur = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? new AdminModel($result) : null;
    }

    public function save(AdminModel $admin) {
        $this->db->beginTransaction();
        try {
            // Insertion dans la table Utilisateurs
            $sqlUtilisateur = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)";
            $statementUtilisateur = $this->db->prepare($sqlUtilisateur);
            $statementUtilisateur->bindValue(':nom', $admin->nom);
            $statementUtilisateur->bindValue(':prenom', $admin->prenom);
            $statementUtilisateur->bindValue(':email', $admin->email);
            $statementUtilisateur->bindValue(':mot_de_passe', $admin->mot_de_passe);
            $statementUtilisateur->execute();

            $adminId = $this->db->lastInsertId();

            // Récupération de l'ID de rôle pour 'Administrateur'
            $sqlRole = "SELECT ID_Role FROM Roles WHERE Nom_Role = 'Administrateur'";
            $statementRole = $this->db->query($sqlRole);
            $roleId = $statementRole->fetchColumn();

            // Insertion dans la table UtilisateursRoles
            $sqlUtilisateurRoles = "INSERT INTO UtilisateursRoles (ID_Utilisateur, ID_Role, statut) VALUES (:id_utilisateur, :id_role, 'Actif')";
            $statementUtilisateurRoles = $this->db->prepare($sqlUtilisateurRoles);
            $statementUtilisateurRoles->bindValue(':id_utilisateur', $adminId);
            $statementUtilisateurRoles->bindValue(':id_role', $roleId);
            $statementUtilisateurRoles->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function findRoleIdByName($roleName) {
        $sql = "SELECT ID_Role FROM Roles WHERE Nom_Role = :roleName";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':roleName', $roleName);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function deleteAdmin($id) {
        $sql = "DELETE FROM Utilisateurs WHERE ID_Utilisateur = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function updateAdmin(AdminModel $admin) {
        $sql = "UPDATE Utilisateurs SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe WHERE ID_Utilisateur = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $admin->id_admin, PDO::PARAM_INT);
        $statement->bindValue(':nom', $admin->nom);
        $statement->bindValue(':prenom', $admin->prenom);
        $statement->bindValue(':email', $admin->email);
        $statement->bindValue(':mot_de_passe', $admin->mot_de_passe);
        return $statement->execute();
    }

    public function findByEmail($email) {
        $sql = "SELECT u.* FROM Utilisateurs u INNER JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur INNER JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE r.Nom_Role = 'Administrateur' AND u.Email = :email";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? new AdminModel($result) : null;
    }

    public function findRoleIdByRoleName($roleName) {
        $sql = "SELECT ID_Role FROM Roles WHERE Nom_Role = :roleName";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':roleName', $roleName);
        $statement->execute();
        return $statement->fetchColumn();
    }


    //------------------------- Update Volontaire Role -------------------------//

    public function updateUserStatus(UserModel $user) {
        // Vérifier que la valeur de 'statut' est valide pour l'ENUM
        $validStatuses = ['Pending', 'Granted', 'Denied'];
        if (!in_array($user->statut, $validStatuses)) {
            throw new Exception("Statut invalide. Les valeurs autorisées sont : 'Pending', 'Granted', 'Denied'.");
        }

        // Préparer la requête SQL pour mettre à jour l'utilisateur
        $sql = "UPDATE Utilisateurs SET statut = :statut WHERE ID_Utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':statut', $user->statut, PDO::PARAM_STR);
        $stmt->bindParam(':id_utilisateur', $user->id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
    }

}
