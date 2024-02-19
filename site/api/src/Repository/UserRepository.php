<?php


require_once '../config/database.php';
require_once '../Models/UserModel.php';

// file: api/src/Repository/UserRepository.php
class UserRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addUser($userData) {
        $query = "INSERT INTO Utilisateurs (Nom, Prenom, Email, Mot_de_passe, Role, Adresse, Telephone, Date_de_naissance, Langues, Nationalite, Date_d_inscription, Statut, Situation, Besoins_specifiques, Photo_Profil, Date_Derniere_Connexion, Statut_Connexion, Emploi, Societe) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $userData['Nom'],
            $userData['Prenom'],
            $userData['Email'],
            $userData['Mot_de_passe'],
            $userData['Role'],
            $userData['Adresse'],
            $userData['Telephone'],
            $userData['Date_de_naissance'],
            $userData['Langues'],
            $userData['Nationalite'],
            $userData['Date_d_inscription'],
            $userData['Statut'],
            $userData['Situation'],
            $userData['Besoins_specifiques'],
            $userData['Photo_Profil'],
            $userData['Date_Derniere_Connexion'],
            $userData['Statut_Connexion'],
            $userData['Emploi'],
            $userData['Societe'], 
            $userData['ID_Utilisateur']
        ]);
        return $this->db->lastInsertId();
    }

    public function updateUser($id, $userData) {
        $query = "UPDATE Utilisateurs SET Nom = ?, Prenom = ?, Email = ?, Mot_de_passe = ?, Role = ?, Adresse = ?, Telephone = ?, Date_de_naissance = ?, Langues = ?, Nationalite = ?, Date_d_inscription = ?, Statut = ?, Situation = ?, Besoins_specifiques = ?, Photo_Profil = ?, Date_Derniere_Connexion = ?, Statut_Connexion = ?, Emploi = ?, Societe = ? WHERE ID_Utilisateur = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $userData['Nom'],
            $userData['Prenom'],
            $userData['Email'],
            $userData['Mot_de_passe'],
            $userData['Role'],
            $userData['Adresse'],
            $userData['Telephone'],
            $userData['Date_de_naissance'],
            $userData['Langues'],
            $userData['Nationalite'],
            $userData['Date_d_inscription'],
            $userData['Statut'],
            $userData['Situation'],
            $userData['Besoins_specifiques'],
            $userData['Photo_Profil'],
            $userData['Date_Derniere_Connexion'],
            $userData['Statut_Connexion'],
            $userData['Emploi'],
            $userData['Societe'], 
            $id
        ]);
    }

    public function deleteUser($id) {
        $query = "DELETE FROM Utilisateurs WHERE ID_Utilisateur = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM Utilisateurs WHERE ID_Utilisateur = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $query = "SELECT * FROM Utilisateurs";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM Utilisateurs WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getErrors() {
        return $this->db->errorInfo();
    }

    public function hasErrors() {
        return $this->db->errorCode() !== '00000';
    }

    public function getUserByEmailAndPassword($email, $password) {
        $query = "SELECT * FROM Utilisateurs WHERE Email = :email AND Mot_de_passe = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmailAndRole($email, $role) {
        $query = "SELECT * FROM Utilisateurs WHERE Email = :email AND Role = :role";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByRole($role) {
        $query = "SELECT * FROM Utilisateurs WHERE Role = :role";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>