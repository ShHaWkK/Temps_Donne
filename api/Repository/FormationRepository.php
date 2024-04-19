<?php
require_once './Models/FormationModel.php';
require_once './Repository/BDD.php';

class FormationRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    // Retrieve all formations a specific volunteer has registered for
    public function getFormationsForVolunteer($userId) {
        $query = "SELECT f.*, i.Date_Inscription 
                  FROM Formations f
                  JOIN Inscriptions_Formations i ON f.ID_Formation = i.ID_Formation
                  WHERE i.ID_Utilisateur = :userId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        $formations = [];
        while ($row = $statement->fetch()) {
            $formations[] = new FormationModel($row);
        }
        return $formations;
    }

    // Retrieve all available formations
    public function getAllFormations() {
        $query = "SELECT * FROM Formations";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $formations = [];
        while ($row = $statement->fetch()) {
            $formations[] = new FormationModel($row);
        }
        return $formations;
    }
    
    public function getFormationById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Formations WHERE ID_Formation = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? new FormationModel($data) : null;
    }

    public function addFormation($data) {
        $stmt = $this->db->prepare("INSERT INTO Formations (Titre, Description, Date_Formation, Duree, Lieu, ID_Organisateur) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['Titre'], $data['Description'], $data['Date_Formation'], $data['Duree'], $data['Lieu'], $data['ID_Organisateur']]);
    }

    public function updateFormation($id, $data) {
        $stmt = $this->db->prepare("UPDATE Formations SET Titre = ?, Description = ?, Date_Formation = ?, Duree = ?, Lieu = ? WHERE ID_Formation = ?");
        return $stmt->execute([$data['Titre'], $data['Description'], $data['Date_Formation'], $data['Duree'], $data['Lieu'], $id]);
    }

    public function deleteFormation($id) {
        $stmt = $this->db->prepare("DELETE FROM Formations WHERE ID_Formation = ?");
        return $stmt->execute([$id]);
    }

     // Method to check if the user is already registered for the formation
     public function isUserRegisteredForFormation($userId, $formationId) {
        $query = "SELECT COUNT(*) FROM Inscriptions_Formations WHERE ID_Utilisateur = :user_id AND ID_Formation = :formation_id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':formation_id', $formationId);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    public function registerVolunteerForFormation($userId, $formationId) {
        // Check for existing registration
        if ($this->isUserRegisteredForFormation($userId, $formationId)) {
            return false; // The user is already registered
        }

        $query = "INSERT INTO Inscriptions_Formations (ID_Utilisateur, ID_Formation, Date_Inscription) VALUES (:user_id, :formation_id, CURDATE())";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':formation_id', $formationId);
        return $statement->execute();
    }

    // Method to unregister a volunteer from a formation
    public function unregisterVolunteerFromFormation($userId, $formationId) {
        // Check for existing registration
        if (!$this->isUserRegisteredForFormation($userId, $formationId)) {
            return false; // The user is not registered
        }

        $query = "DELETE FROM Inscriptions_Formations WHERE ID_Utilisateur = :user_id AND ID_Formation = :formation_id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':formation_id', $formationId);
        return $statement->execute();
    }
}
