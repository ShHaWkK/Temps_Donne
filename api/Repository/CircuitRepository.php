<?php

require_once './Repository/BDD.php';
require_once './Models/CircuitModel.php';

class CircuitRepository {

    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function getDbConnection() {
        return $this->db;
    }

    public function findAll() {
        return selectDB('Circuits', '*');
    }

    public function findById($id) {
        $condition = "ID_Circuit = :id";
        $values = [':id' => $id];
        $results = selectDB('Circuits', '*', $condition, $values);
        return $results ? new CircuitModel($results[0]) : null;
    }

    public function save(CircuitModel $circuit) {
        $columnArray = ['Date_Circuit', 'Itineraire', 'ID_Chauffeur', 'QR_Code'];
        $columnData = [
            $circuit->date_circuit,
            $circuit->itineraire,
            $circuit->id_chauffeur,
            $circuit->qr_code
        ];
        return insertDB('Circuits', $columnArray, $columnData);
    }

    public function update(CircuitModel $circuit) {
        $columnArray = ['Date_Circuit', 'Itineraire', 'ID_Chauffeur', 'QR_Code'];
        $columnData = [
            $circuit->date_circuit,
            $circuit->itineraire,
            $circuit->id_chauffeur,
            $circuit->qr_code,
            $circuit->id_circuit
        ];
        $condition = "ID_Circuit = ?";
        return updateDB('Circuits', $columnArray, $columnData, $condition);
    }

    public function delete($id) {
        $condition = "ID_Circuit = ?";
        $conditionValues = [$id];
        return deleteDB('Circuits', $condition, $conditionValues);
    }

    public function findByDate($date) {
        $condition = "DATE(Date_Circuit) = ?";
        $values = [$date];
        return selectDB('Circuits', '*', $condition, $values);
    }

    public function findByChauffeur($chauffeurId) {
        $condition = "ID_Chauffeur = ?";
        $values = [$chauffeurId];
        return selectDB('Circuits', '*', $condition, $values);
    }

    public function updateQrCodePath($id, $path) {
        $stmt = $this->db->prepare("UPDATE Circuits SET QR_Code = :path WHERE ID_Circuit = :id");
        $stmt->execute([':path' => $path, ':id' => $id]);
    }
}

