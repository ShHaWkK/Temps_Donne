<?php

require_once './Repository/BDD.php';

class EntrepotRepository {

    private $db;

    public function __construct() {
        $this->db = connectDB(); 
    }

    public function getDbConnection() {
        return $this->db;
    }

    public function findAll() {
        return selectDB('entrepot', '*');
    }

    public function findById($id) {
        $condition = "ID_Entrepot = ?";
        $values = [$id];
        $results = selectDB('entrepot', '*', $condition, $values);
        return $results ? $results[0] : null;
    }

    public function save($entrepot) {
        // Correction ici : utiliser les propriétés de l'objet $entrepot
        $columnArray = ['Adresse', 'Capacite_Stockage', 'nom'];
        $columnData = [
            $entrepot->adresse,
            $entrepot->capaciteStockage,
            $entrepot->nom
        ];
        return insertDB('entrepot', $columnArray, $columnData);
    }
    

    public function update($entrepot) {
        $columnArray = ['Adresse', 'Capacite_Stockage'];
        $columnData = [
            $entrepot->nom,
            $entrepot->adresse,
            $entrepot->capaciteStockage,
            $entrepot->id 
        ];
        $condition = "ID_Entrepot = ?";
        return updateDB('entrepot', $columnArray, $columnData, $condition);
    }

    public function delete($id) {
        $condition = "ID_Entrepot = ?";
        $conditionValues = [$id];
        return deleteDB('entrepot', $condition, $conditionValues);
    }
}

?>
