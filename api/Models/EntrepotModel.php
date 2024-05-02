<?php

class EntrepotModel {
    public $id;
    public $nom;
    public $adresse;
    public $capaciteStockage;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'] ?? null;
        $this->adresse = $data['adresse'] ?? '';
        $this->capaciteStockage = $data['capaciteStockage'] ?? 0.0;
    }

    public function validate() {
        if (empty($this->adresse) || empty($this->capaciteStockage)) {
            throw new Exception("Missing required fields", 400);
        }
        if (!is_string($this->adresse)) {
            throw new Exception("Address must be a string", 400);
        }
        if (!is_numeric($this->capaciteStockage) || $this->capaciteStockage <= 0) {
            throw new Exception("Storage capacity must be a positive number", 400);
    }
}
}

?>
