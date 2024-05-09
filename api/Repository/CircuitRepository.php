<?php
// Repository/CircuitRepository.php

require_once './Repository/BDD.php'; // Ensure this path is correct.

class CircuitRepository {

    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function getDbConnection() {
        return $this->db;
    }


    public function findAll() {
        return selectDB('circuits', '*'); // Assuming 'circuits' is your table name.
    }

    public function findById($id) {
        $condition = "id = ?";
        $values = [$id];
        $results = selectDB('circuits', '*', $condition, $values);
        return $results ? $results[0] : null; // Assumes id is unique and returns a single record.
    }

    public function save($circuit) {
        $columnArray = ['route', 'collection_time', 'driver_id', 'partner_merchants'];
        $columnData = [
            json_encode($circuit->route),
            $circuit->collectionTime,
            $circuit->driverId,
            json_encode($circuit->partnerMerchants)
        ];
        return insertDB('circuits', $columnArray, $columnData);
    }

    public function update($circuit) {
        $columnArray = ['route', 'collection_time', 'driver_id', 'partner_merchants'];
        $columnData = [
            json_encode($circuit->route),
            $circuit->collectionTime,
            $circuit->driverId,
            json_encode($circuit->partnerMerchants),
            $circuit->id
        ];
        $condition = "id = ?";
        return updateDB('circuits', $columnArray, $columnData, $condition);
    }

    public function delete($id) {
        $condition = "id = ?";
        $conditionValues = [$id];
        return deleteDB('circuits', $condition, $conditionValues);
    }

    public function findByDate($date) {
        $condition = "DATE(collection_time) = ?";
        $values = [$date];
        return selectDB('circuits', '*', $condition, $values);
    }

    public function findByChauffeur($chauffeurId) {
        $condition = "driver_id = ?";
        $values = [$chauffeurId];
        return selectDB('circuits', '*', $condition, $values);
    }

    public function planRoute($startPoint, $endPoint) {
        // Implement your route planning logic here.

    }
}

?>