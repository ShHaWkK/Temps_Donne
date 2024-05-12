<?php

require_once './Models/CommercantModel.php';

class CommercantRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM Commercants");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Commercants WHERE ID_Commercant = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save(Commercant $commercant) {
        if ($commercant->id) {
            $stmt = $this->db->prepare("UPDATE Commercants SET Nom = :nom, Adresse = :adresse WHERE ID_Commercant = :id");
            $stmt->execute([
                ':nom' => $commercant->nom,
                ':adresse' => $commercant->adresse,
                ':id' => $commercant->id
            ]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO Commercants (Nom, Adresse) VALUES (:nom, :adresse)");
            $stmt->execute([
                ':nom' => $commercant->nom,
                ':adresse' => $commercant->adresse
            ]);
            return $this->db->lastInsertId();
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Commercants WHERE ID_Commercant = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>