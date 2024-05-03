<?php

class StockModel {
    public $id_stock;
    public $type_article;
    public $quantite;
    public $poids_total;
    public $poids_individuel;
    public $volume_total;
    public $volume_individuel;
    public $date_de_peremption;
    public $emplacement;
    public $urgence;
    public $date_de_reception;
    public $statut;
    public $id_don;
    public $qr_code;

    public function __construct($data) {
        $this->id_stock = $data['id_stock'] ?? null;
        $this->type_article = $data['type_article'];
        $this->quantite = $data['quantite'];
        $this->poids_total = $data['poids_total'];
        $this->poids_individuel = $data['poids_individuel'];
        $this->volume_total = $data['volume_total'];
        $this->volume_individuel = $data['volume_individuel'];
        $this->date_de_peremption = $data['date_de_peremption'];
        $this->emplacement = $data['emplacement'];
        $this->urgence = $data['urgence'] ?? false;
        $this->date_de_reception = $data['date_de_reception'];
        $this->statut = $data['statut'] ?? 'en_route';
        $this->id_don = $data['id_don'];
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

        if (!empty($this->urgence) && !is_bool($this->urgence)) {
            throw new Exception("Urgence must be a boolean value", 400);
        }

        if (!empty($this->emplacement) && !is_string($this->emplacement)) {
            throw new Exception("Emplacement must be a string", 400);
        }
    }
}

?>
