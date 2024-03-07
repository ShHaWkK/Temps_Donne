<?php
// file : api/Repository/AdminRepository.php
require_once './Models/AdminModel.php';
require_once './Repository/BDD.php';

class AdminRepository {
    private $bdd;

    public function __construct() {
        $this->bdd = connectDB();
    }

    public function findAll() {
        $sql = "SELECT u.* FROM Utilisateurs u INNER JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur INNER JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE r.Nom_Role = 'Administrateur'";
        $statement = $this->bdd->prepare($sql);
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
        $statement = $this->bdd->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? new AdminModel($result) : null;
    }

    public function save(AdminModel $admin) {
        $this->bdd->beginTransaction();
        try {
            // Insertion dans la table Utilisateurs
            $sqlUtilisateur = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)";
            $statementUtilisateur = $this->bdd->prepare($sqlUtilisateur);
            $statementUtilisateur->bindValue(':nom', $admin->nom);
            $statementUtilisateur->bindValue(':prenom', $admin->prenom);
            $statementUtilisateur->bindValue(':email', $admin->email);
            $statementUtilisateur->bindValue(':mot_de_passe', $admin->mot_de_passe);
            $statementUtilisateur->execute();

            $adminId = $this->bdd->lastInsertId();

            // Récupération de l'ID de rôle pour 'Administrateur'
            $sqlRole = "SELECT ID_Role FROM Roles WHERE Nom_Role = 'Administrateur'";
            $statementRole = $this->bdd->query($sqlRole);
            $roleId = $statementRole->fetchColumn();

            // Insertion dans la table UtilisateursRoles
            $sqlUtilisateurRoles = "INSERT INTO UtilisateursRoles (ID_Utilisateur, ID_Role, statut) VALUES (:id_utilisateur, :id_role, 'Actif')";
            $statementUtilisateurRoles = $this->bdd->prepare($sqlUtilisateurRoles);
            $statementUtilisateurRoles->bindValue(':id_utilisateur', $adminId);
            $statementUtilisateurRoles->bindValue(':id_role', $roleId);
            $statementUtilisateurRoles->execute();

            $this->bdd->commit();
            return true;
        } catch (Exception $e) {
            $this->bdd->rollBack();
            throw $e;
        }
    }

    public function findRoleIdByName($roleName) {
        $sql = "SELECT ID_Role FROM Roles WHERE Nom_Role = :roleName";
        $statement = $this->bdd->prepare($sql);
        $statement->bindValue(':roleName', $roleName);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function deleteAdmin($id) {
        $sql = "DELETE FROM Utilisateurs WHERE ID_Utilisateur = :id";
        $statement = $this->bdd->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function updateAdmin(AdminModel $admin) {
        $sql = "UPDATE Utilisateurs SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe WHERE ID_Utilisateur = :id";
        $statement = $this->bdd->prepare($sql);
        $statement->bindValue(':id', $admin->id_admin, PDO::PARAM_INT);
        $statement->bindValue(':nom', $admin->nom);
        $statement->bindValue(':prenom', $admin->prenom);
        $statement->bindValue(':email', $admin->email);
        $statement->bindValue(':mot_de_passe', $admin->mot_de_passe);
        return $statement->execute();
    }

    public function findByEmail($email) {
        $sql = "SELECT u.* FROM Utilisateurs u INNER JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur INNER JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE r.Nom_Role = 'Administrateur' AND u.Email = :email";
        $statement = $this->bdd->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? new AdminModel($result) : null;
    }

    public function findRoleIdByRoleName($roleName) {
        $sql = "SELECT ID_Role FROM Roles WHERE Nom_Role = :roleName";
        $statement = $this->bdd->prepare($sql); 
        $statement->bindValue(':roleName', $roleName);
        $statement->execute();
        return $statement->fetchColumn();
    }


    //------------------------- Update Volontaire Role -------------------------//

    public function updateVolunteerStatus($userId, $statusVolunteer, $statusUserRole) {
        $this->bdd->beginTransaction();
        try {
            // Mise à jour du statut du bénévole dans la table Utilisateurs
            $sqlUtilisateur = "UPDATE Utilisateurs SET statut_benevole = :statusVolunteer WHERE ID_Utilisateur = :userId";
            $stmtUtilisateur = $this->bdd->prepare($sqlUtilisateur);
            $stmtUtilisateur->bindValue(':statusVolunteer', $statusVolunteer);
            $stmtUtilisateur->bindValue(':userId', $userId);
            $stmtUtilisateur->execute();
    
            // Mise à jour du statut du rôle dans la table UtilisateursRoles
            $sqlUtilisateurRoles = "UPDATE UtilisateursRoles SET Statut = :statusUserRole WHERE ID_Utilisateur = :userId AND ID_Role = (SELECT ID_Role FROM Roles WHERE Nom_Role = 'Benevole')";
            $stmtUtilisateurRoles = $this->bdd->prepare($sqlUtilisateurRoles);
            $stmtUtilisateurRoles->bindValue(':statusUserRole', $statusUserRole);
            $stmtUtilisateurRoles->bindValue(':userId', $userId);
            $stmtUtilisateurRoles->execute();
    
            $this->bdd->commit();
        } catch (Exception $e) {
            $this->bdd->rollBack();
            throw $e;
        }
    }
    
}
