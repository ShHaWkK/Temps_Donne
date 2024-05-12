<?php

require_once './Models/DonModel.php'; 
require_once './Repository/BDD.php';

class DonRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDons() {
        $stmt = $this->db->prepare("SELECT * FROM Dons");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Don');
    }

    public function getDonById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Dons WHERE ID_Don = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject('Don');
    }

    public function createDon($don) {
        $stmt = $this->db->prepare("INSERT INTO Dons (Montant, Type_don, Date_Don, ID_Donateur, Commentaires, ID_Source) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$don->montant, $don->type_don, $don->date_don, $don->id_donateur, $don->commentaires, $don->id_source]);
    }

    public function updateDon($don) {
        $stmt = $this->db->prepare("UPDATE Dons SET Montant = ?, Type_don = ?, Date_Don = ?, ID_Donateur = ?, Commentaires = ?, ID_Source = ? WHERE ID_Don = ?");
        return $stmt->execute([$don->montant, $don->type_don, $don->date_don, $don->id_donateur, $don->commentaires, $don->id_source, $don->id]);
    }

    public function deleteDon($id) {
        $stmt = $this->db->prepare("DELETE FROM Dons WHERE ID_Don = ?");
        return $stmt->execute([$id]);
    }
}
?>