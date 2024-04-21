
<?php
// Path: api/Models/StockModel.php

class StockModel {
    public $id_stock;
    public $type_article;
    public $quantite;
    public $date_de_peremption;
    public $urgence;
    public $qr_code;
    public $emplacement;

    public function __construct($data) {
        $this->id_stock = $data['id_stock'] ?? null;
        $this->type_article = $data['type_article'];
        $this->quantite = $data['quantite'];
        $this->date_de_peremption = $data['date_de_peremption'];
        $this->urgence = $data['urgence'] ?? false;
        $this->emplacement = $data['emplacement'] ?? null;
    }

    public function validate() {
        if (empty($this->type_article) || empty($this->quantite) || empty($this->date_de_peremption)) {
            throw new Exception("Missing required fields", 400);
        }
        if (!is_numeric($this->quantite) || $this->quantite <= 0) {
            throw new Exception("Quantity must be a positive number", 400);
        }
        if (strtotime($this->date_de_peremption) === false) {
            throw new Exception("Invalid date format. Date must be in the format 'YYYY-MM-DD'", 400);
        }
        if ($this->date_de_peremption < date('Y-m-d')) {
            throw new Exception("Expiration date must be greater than the current date", 400);
        }
    }
}

?>