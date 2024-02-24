<?php

require_once './Models/UserModel.php';
require_once './Repository/BDD.php';

class UserRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //-------------------------------------------------------------------------------------------------------------------------------------------------//
    public function save(UserModel $user) {
        $query = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, role, adresse, telephone, date_de_naissance, langues, nationalite, date_d_inscription, statut, situation, besoins_specifiques, photo_profil, emploi, societe, est_verifie, code_verification, type_permis) VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :adresse, :telephone, :date_de_naissance, :langues, :nationalite, :date_d_inscription, :statut, :situation, :besoins_specifiques, :photo_profil, :emploi, :societe, :est_verifie, :code_verification, :type_permis)";

        $statement = $this->db->prepare($query);

        // Lier les valeurs
        $statement->bindValue(':nom', $user->nom);
        $statement->bindValue(':prenom', $user->prenom);
        $statement->bindValue(':email', $user->email);
        $statement->bindValue(':mot_de_passe', $user->mot_de_passe);
        $statement->bindValue(':role', $user->role);
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

        return $statement->execute();
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

    public function save(UserModel $user) {
        $query = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, role, adresse, telephone, date_de_naissance, langues, nationalite, date_d_inscription, statut, situation, besoins_specifiques, photo_profil, emploi, societe, est_verifie, code_verification, type_permis, statut_benevole) VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :adresse, :telephone, :date_de_naissance, :langues, :nationalite, :date_d_inscription, :statut, :situation, :besoins_specifiques, :photo_profil, :emploi, :societe, :est_verifie, :code_verification, :type_permis, :statut_benevole)";

        $statement = $this->db->prepare($query);

        // Lier les valeurs
        $statement->bindValue(':nom', $user->nom);
        $statement->bindValue(':prenom', $user->prenom);
        $statement->bindValue(':email', $user->email);
        $statement->bindValue(':mot_de_passe', $user->mot_de_passe);
        $statement->bindValue(':role', $user->role);
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
        $statement->bindValue(':statut_benevole', $user->statut_benevole);

        return $statement->execute();
    }


}