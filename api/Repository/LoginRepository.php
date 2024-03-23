<?php
// File : api/Repository/LoginRepository.php

class LoginRepository {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByCredentials($email, $password) {
        $query = "SELECT * FROM Utilisateurs WHERE Email = :email";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['Mot_de_passe'])) {
            return $user; 
        }
        return null; 
    }
    

    public function findRolesByUserId($userId) {
        $query = "SELECT r.Nom_Role FROM UtilisateursRoles ur JOIN Roles r ON ur.ID_Role = r.ID_Role WHERE ur.ID_Utilisateur = :userId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
}


?>