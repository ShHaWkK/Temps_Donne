
<?php
// Path: api/Models/StockModel.php

class StockModel {
    public $id_stock;
    public $type_article;
    public $quantite;
    public $date_peremption;
    public $emplacement;

    public function __construct($data) {
        $this->id_stock = $data['id_stock'] ?? null;
        $this->type_article = $data['type_article'];
        $this->quantite = $data['quantite'];
        $this->date_peremption = $data['date_peremption'];
        $this->emplacement = $data['emplacement'];

        $this->validate();
    }

    private function validate() {
        // Ajoutez ici les règles de validation pour les stocks
        if (empty($this->type_article) || empty($this->quantite) || empty($this->date_peremption) || empty($this->emplacement)) {
            throw new Exception("Missing required fields", 400);
        }
        if (!is_numeric($this->quantite) || $this->quantite <= 0) {
            throw new Exception("Quantity must be a positive number", 400);
        }
        if (strtotime($this->date_peremption) === false) {
            throw new Exception("Invalid date format. Date must be in the format 'YYYY-MM-DD'", 400);
        }

        // Vérifiez que la date de péremption est supérieure à la date actuelle
        $currentDate = date('Y-m-d');
        if ($this->date_peremption < $currentDate) {
            throw new Exception("Expiration date must be greater than the current date", 400);
        }

        // Vérifiez que l'emplacement est un texte
        if (!is_string($this->emplacement)) {
            throw new Exception("Location must be a string", 400);
        }

        // Vérifiez que l'emplacement est un texte
        if (!is_string($this->type_article)) {
            throw new Exception("Type of article must be a string", 400);
        }

    }
}
?>