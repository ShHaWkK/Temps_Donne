<?php
//file : api/Repository/UserRepository.php
require_once './Models/UserModel.php';
require_once './Repository/BDD.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



class UserRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //-------------------------------------------------------------------------------------------------------------------------------------------------//
    public function save(UserModel $user) {
        if (empty($user->nom)) {
            throw new Exception("Le champ 'nom' ne peut pas être vide.");
        }

        $query = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, adresse, telephone, date_de_naissance, langues, nationalite, date_d_inscription, statut, situation, besoins_specifiques, photo_profil, emploi, societe, code_verification, type_permis, date_derniere_connexion, statut_connexion, role) VALUES (:nom, :prenom, :email, :mot_de_passe, :adresse, :telephone, :date_de_naissance, :langues, :nationalite, :date_d_inscription, :statut, :situation, :besoins_specifiques, :photo_profil, :emploi, :societe, :code_verification, :type_permis, :date_derniere_connexion, :statut_connexion, :role)";
        $statement = $this->db->prepare($query);

        $statement->bindValue(':nom', $user->nom);
        $statement->bindValue(':prenom', $user->prenom);
        $statement->bindValue(':email', $user->email);
        $statement->bindValue(':mot_de_passe', $user->mot_de_passe);
        $statement->bindValue(':adresse', $user->adresse);
        $statement->bindValue(':telephone', $user->telephone);
        $statement->bindValue(':date_de_naissance', $user->date_de_naissance);
        $statement->bindValue(':langues', json_encode($user->langues));
        $statement->bindValue(':nationalite', $user->nationalite);
        $statement->bindValue(':date_d_inscription', $user->date_d_inscription);
        $statement->bindValue(':statut', $user->statut);
        $statement->bindValue(':situation', $user->situation);
        $statement->bindValue(':besoins_specifiques', $user->besoins_specifiques);
        $statement->bindValue(':photo_profil', $user->photo_profil);
        $statement->bindValue(':emploi', $user->emploi);
        $statement->bindValue(':societe', $user->societe);
        $statement->bindValue(':code_verification', $user->code_verification);
        $statement->bindValue(':type_permis', $user->type_permis);
        $statement->bindValue(':date_derniere_connexion', $user->date_derniere_connexion);
        $statement->bindValue(':statut_connexion', $user->statut_connexion);
        $statement->bindValue(':role', $user->role);

        // Ajouter l'instruction de débogage juste avant d'exécuter la requête
        error_log("Sauvegarde de l'utilisateur : " . print_r($user, true));

        $success = $statement->execute();
        if (!$success) {
            error_log("Erreur lors de la sauvegarde de l'utilisateur : " . print_r($statement->errorInfo(), true));
            throw new Exception("Erreur lors de la sauvegarde de l'utilisateur.");
        } else {
            // Si l'exécution a réussi, obtenir l'ID inséré
            $insertedId = $this->db->lastInsertId();
            error_log("ID de l'utilisateur inséré : " . $insertedId);
            return $insertedId;
        }
    }

    //-------------------------------------------------------------------------------------------------------------------------------------------------//
    public function updateLastLoginDate($userId, $date) {
        $query = "UPDATE Utilisateurs SET date_derniere_connexion = :date WHERE id_utilisateur = :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':id', $userId);
        return $statement->execute();
    }


//----------------- Il sert à vérifier si l'email existe déjà dans la base de données -----------------//
    public function findByEmail($email) {
        $query = "SELECT * FROM Utilisateurs WHERE email = :email LIMIT 1";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user ? new UserModel($user) : null;
    }

    //----------------- Update => Mise à jour des informations de l'utilisateur -----------------//
    public function updateUser(userModel $user, array $fieldsToUpdate)
    {
        $query = "UPDATE Utilisateurs SET ";

        $sets = [];
        $params = [];
        foreach ($fieldsToUpdate as $field) {
            $sets[] = "$field = :$field";
            $params[":$field"] = $user->$field;
        }

        $query .= implode(", ", $sets);
        $query .= " WHERE ID_Utilisateur = :id_utilisateur";
        $params[":id_utilisateur"] = $user->id_utilisateur;

        $statement = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        return $statement->execute();
    }

    // ----------------- Réinitialisation du mot de passe -----------------//

    public function resetPassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE Utilisateurs SET mot_de_passe = :newPassword WHERE id_utilisateur = :id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $userId);
        $statement->bindValue(':newPassword', $hashedPassword);

        return $statement->execute();
    }

    //----------------- Find all => Récupération de tous les utilisateurs -----------------//

    public function findAll() {
        $query = "SELECT * FROM Utilisateurs";
        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //----------------- Delete => Suppression d'un utilisateur -----------------//

    public function deleteUser($id) {
        $query = "DELETE FROM Utilisateurs WHERE id_utilisateur = :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    //----------------- Assigner un rôle à un utilisateur -----------------//
    /*
    public function assignRoleToUser($userId, $roleId, $status = 'Actif') {
        $query = "INSERT INTO UtilisateursRoles (ID_Utilisateur, ID_Role, Statut) VALUES (:userId, :roleId, :status)";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':roleId', $roleId);
        $statement->bindValue(':status', $status);
        $success = $statement->execute();
        if (!$success) {
            throw new Exception("Error assigning role to user.");
        }
    }
    */
    //----------------- Récupérer les rôles d'un utilisateur -----------------//
    public function getUserRoles($userId) {
        $query = "SELECT r.Nom_Role FROM UtilisateursRoles ur JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE ur.ID_Utilisateur = :userId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //----------------- Mettre à jour le statut d'un rôle d'un utilisateur -----------------//
    /*
    public function updateUserRole($userId, $roleId, $newStatus) {
        $query = "UPDATE UtilisateursRoles SET statut = :newStatus WHERE ID_Utilisateur = :userId AND ID_Role = :roleId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':newStatus', $newStatus);
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':roleId', $roleId);
        $statement->execute();
    }
*/
    //------------------- findRoleidByRoleName -------------------//

    public function findRoleIdByRoleName($roleName) {
        $sql = "SELECT ID_Role FROM Roles WHERE Nom_Role = :roleName";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':roleName', $roleName);
        $statement->execute();
        return $statement->fetchColumn();
    }

    //--------------------- Récupérer le statut du bénévole ---------------------//

    public function isUserVolunteer($userId) {
        $query = "SELECT COUNT(*) FROM UtilisateursRoles WHERE ID_Utilisateur = :userId AND ID_Role = (SELECT ID_Role FROM Roles WHERE Nom_Role = 'Benevole')";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchColumn() > 0;
    }

    //--------------------- Voir si un utilisateur existe ---------------------//

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Utilisateurs WHERE id_utilisateur = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM Utilisateurs WHERE Utilisateurs.ID_Utilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user){
            throw new Exception("L'id ne correspond à aucun utilisateur");
        }

        $data = array_change_key_case($user, CASE_LOWER);

        if (!$user) {
            return null; // Utilisateur non trouvé
        }
        $userModel=new UserModel($user);
        return $userModel;
    }

    public function getAllUsersByRole($role)
    {
        $sql = "SELECT * FROM Utilisateurs WHERE Role = :role";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $user = $stmt->execute(PDO::FETCH_ASSOC);
    }

    public function getAllUsersByRoleAndStatus($role,$statut)
    {
        $sql = "SELECT * FROM Utilisateurs WHERE Role = :role AND Statut= :statut";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $user = $stmt->execute(PDO::FETCH_ASSOC);
    }

}