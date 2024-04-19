<?php
require_once './Models/FormationModel.php';
require_once './Repository/BDD.php';

class FormationRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function getAllFormations() {
        $stmt = $this->db->prepare("SELECT * FROM Formations");
        $stmt->execute();
        $formations = [];
        while ($row = $stmt->fetch()) {
            $formations[] = new FormationModel($row);
            error_log(print_r($row, true));  
        }
        if (empty($formations)) {
            error_log("No formations found");  
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
}
