<?php
require_once '../config/database.php';
require_once '../Models/Admin.php';


class AdminRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Méthode pour trouver un administrateur par son email
    public function findAdminByEmail($email) {
        $query = "SELECT * FROM Administrateurs WHERE Email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer tous les administrateurs
    public function findAllAdmins() {
        // requête SQL pour récupérer tous les administrateurs
        $query = "SELECT * FROM Administrateurs";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour créer un administrateur
    public function createAdmin($adminData) {
        $query = "INSERT INTO Administrateurs (Nom, Prenom, Email, Mot_de_passe, Role, Photo_Profil) VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :photo_profil)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nom', $adminData['Nom']);
        $stmt->bindParam(':prenom', $adminData['Prenom']);
        $stmt->bindParam(':email', $adminData['Email']);
        $stmt->bindParam(':mot_de_passe', $adminData['Mot_de_passe']);
        $stmt->bindParam(':role', $adminData['Role']);
        $stmt->bindParam(':photo_profil', $adminData['Photo_Profil']);
        return $stmt->execute();
    }

    // Méthode pour mettre à jour un administrateur
    public function updateAdmin($adminData) {
        $query = "UPDATE Administrateurs SET Nom = :nom, Prenom = :prenom, Email = :email, Mot_de_passe = :mot_de_passe, Role = :role, Photo_Profil = :photo_profil WHERE ID_Administrateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $adminData['ID_Administrateur']);
        $stmt->bindParam(':nom', $adminData['Nom']);
        $stmt->bindParam(':prenom', $adminData['Prenom']);
        $stmt->bindParam(':email', $adminData['Email']);
        $stmt->bindParam(':mot_de_passe', $adminData['Mot_de_passe']);
        $stmt->bindParam(':role', $adminData['Role']);
        $stmt->bindParam(':photo_profil', $adminData['Photo_Profil']);
        return $stmt->execute();
    }

    // Méthode pour supprimer un administrateur
    public function deleteAdmin($adminId) {
        $query = "DELETE FROM Administrateurs WHERE ID_Administrateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $adminId);
        return $stmt->execute();
    }

    // Méthode pour récupérer les erreurs

    public function getErrors() {
        return $this->db->errorInfo();
    }

    public function hasErrors() {
        return $this->db->errorCode() !== '00000';
    }

    public function clearErrors() {
        $this->db->errorCode();
    }


}
?>
