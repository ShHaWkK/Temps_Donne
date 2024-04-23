<?php
// File : api/Repository/LoginRepository.php


class LoginRepository {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByCredentials($email, $password) {
        $query = "SELECT * FROM Utilisateurs WHERE Email = :email AND Mot_de_passe = :password";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        var_dump($user);
    
        if ($user && password_verify($password, $user['Mot_de_passe'])) {
            return $user;
        }
        return null; 
    }
    
    
    public function findUserWithRolesByEmail($email) {
        $query = "SELECT u.*, GROUP_CONCAT(r.Nom_Role) as roles
                  FROM Utilisateurs u
                  LEFT JOIN UtilisateursRoles ur ON u.ID_Utilisateur = ur.ID_Utilisateur
                  LEFT JOIN Roles r ON ur.ID_Role = r.ID_Role
                  WHERE u.Email = :email
                  GROUP BY u.ID_Utilisateur";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    

    public function findUserIdByEmail($email) {
        $query = "SELECT ID_Utilisateur FROM Utilisateurs WHERE Email = :email";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        return $statement->fetchColumn();
    }     
}


?>