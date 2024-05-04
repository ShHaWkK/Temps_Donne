<?php
require_once 'BDD.php';

class EntrepotRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save($entrepot) {
        $stmt = $this->db->prepare("INSERT INTO Entrepots (Nom, Adresse, Volume_Total, Volume_Utilise) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $entrepot->nom, $entrepot->adresse, $entrepot->volumeTotal, $entrepot->volumeUtilise
        ]);
        return $this->db->lastInsertId();
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM Entrepots");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Entrepots WHERE ID_Entrepot = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($entrepot) {
        $stmt = $this->db->prepare("UPDATE Entrepots SET Nom = ?, Adresse = ?, Volume_Total = ?, Volume_Utilise = ? WHERE ID_Entrepot = ?");
        $stmt->execute([
            $entrepot->nom, $entrepot->adresse, $entrepot->volumeTotal, $entrepot->volumeUtilise, $entrepot->id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Entrepots WHERE ID_Entrepot = ?");
        $stmt->execute([$id]);
    }
}


?>
