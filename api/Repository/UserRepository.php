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
    
        $query = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, adresse, telephone, date_de_naissance, langues, nationalite, date_d_inscription, statut, situation, besoins_specifiques, photo_profil, emploi, societe, est_verifie, code_verification, type_permis) VALUES (:nom, :prenom, :email, :mot_de_passe, :adresse, :telephone, :date_de_naissance, :langues, :nationalite, :date_d_inscription, :statut, :situation, :besoins_specifiques, :photo_profil, :emploi, :societe, :est_verifie, :code_verification, :type_permis)";
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
        $statement->bindValue(':statut', $user->statut, PDO::PARAM_BOOL);
        $statement->bindValue(':situation', $user->situation);
        $statement->bindValue(':besoins_specifiques', $user->besoins_specifiques);
        $statement->bindValue(':photo_profil', $user->photo_profil);
        $statement->bindValue(':emploi', $user->emploi);
        $statement->bindValue(':societe', $user->societe);
        $statement->bindValue(':est_verifie', $user->est_verifie, PDO::PARAM_BOOL);
        $statement->bindValue(':code_verification', $user->code_verification);
        $statement->bindValue(':type_permis', $user->type_permis);

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



// ----------------- Récupération des informations de l'utilisateur -----------------//
    public function updateUserProfile(UserModel $user) {
        $query = "UPDATE Utilisateurs SET nom = :nom, prenom = :prenom, adresse = :adresse, telephone = :telephone, langues = :langues, nationalite = :nationalite, situation = :situation, besoins_specifiques = :besoins_specifiques, emploi = :emploi, societe = :societe, type_permis = :type_permis WHERE id_utilisateur = :id";

        $statement = $this->db->prepare($query);


        $statement->bindValue(':id', $user->id_utilisateur);
        $statement->bindValue(':nom', $user->nom);
        $statement->bindValue(':prenom', $user->prenom);
        $statement->bindValue(':adresse', $user->adresse);
        $statement->bindValue(':telephone', $user->telephone);
        $statement->bindValue(':langues', json_encode($user->langues));
        $statement->bindValue(':nationalite', $user->nationalite);
        $statement->bindValue(':situation', $user->situation);
        $statement->bindValue(':besoins_specifiques', $user->besoins_specifiques);
        $statement->bindValue(':emploi', $user->emploi);
        $statement->bindValue(':societe', $user->societe);
        $statement->bindValue(':type_permis', $user->type_permis);

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

    //----------------- Update => Mise à jour des informations de l'utilisateur -----------------//

    public function updateUser(UserModel $user) {
        $query = "UPDATE Utilisateurs SET nom = :nom, prenom = :prenom, adresse = :adresse, telephone = :telephone, langues = :langues, nationalite = :nationalite, situation = :situation, besoins_specifiques = :besoins_specifiques, emploi = :emploi, societe = :societe, type_permis = :type_permis, photo_profil = :photo_profil WHERE id_utilisateur = :id";

        $statement = $this->db->prepare($query);

        // Lier les valeurs
        $statement->bindValue(':id', $user->id_utilisateur);
        $statement->bindValue(':nom', $user->nom);
        $statement->bindValue(':prenom', $user->prenom);
        $statement->bindValue(':adresse', $user->adresse);
        $statement->bindValue(':telephone', $user->telephone);
        $statement->bindValue(':langues', json_encode($user->langues));
        $statement->bindValue(':nationalite', $user->nationalite);
        $statement->bindValue(':situation', $user->situation);
        $statement->bindValue(':besoins_specifiques', $user->besoins_specifiques);
        $statement->bindValue(':emploi', $user->emploi);
        $statement->bindValue(':societe', $user->societe);
        $statement->bindValue(':type_permis', $user->type_permis);
        $statement->bindValue(':photo_profil', $user->photo_profil);

        return $statement->execute();
    }

    //----------------- Assigner un rôle à un utilisateur -----------------//
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
    //----------------- Récupérer les rôles d'un utilisateur -----------------//
    public function getUserRoles($userId) {
        $query = "SELECT r.Nom_Role FROM UtilisateursRoles ur JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE ur.ID_Utilisateur = :userId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //----------------- Mettre à jour le statut d'un rôle d'un utilisateur -----------------//
    public function updateUserRole($userId, $roleId, $newStatus) {
        $query = "UPDATE UtilisateursRoles SET statut = :newStatus WHERE ID_Utilisateur = :userId AND ID_Role = :roleId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':newStatus', $newStatus);
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':roleId', $roleId);
        $statement->execute();
    }

    //------------------- findRoleidByRoleName -------------------//

    public function findRoleIdByRoleName($roleName) {
        $sql = "SELECT ID_Role FROM Roles WHERE Nom_Role = :roleName";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':roleName', $roleName);
        $statement->execute();
        return $statement->fetchColumn();
    }
    public function updateUserValidationStatus($userId, $status) {
        $query = "UPDATE Utilisateurs SET statut_benevole = :status WHERE id_utilisateur = :userId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->bindValue(':status', $status);
        $statement->execute();
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
    
    

    



}