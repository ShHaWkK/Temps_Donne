<?php

class StockModel {
    public $id_stock;
    public $id_entrepot;
    public $id_produit;
    public $quantite;
    public $poids_total;
    public $volume_total;
    public $date_de_reception;
    public $statut;
    public $qr_code;
    public $date_de_peremption;

    public function __construct($data) {
        $this->id_stock = $data['id_stock'] ?? null;
        $this->id_entrepot = $data['id_entrepot'];
        $this->id_produit = $data['id_produit'];
        $this->quantite = $data['quantite'];
        $this->poids_total = $data['poids_total'];
        $this->volume_total = $data['volume_total'];
        $this->date_de_reception = $data['date_de_reception'];
        $this->statut = $data['statut'] ?? 'en_route';
        $this->qr_code = $data['qr_code'] ?? null;
        $this->date_de_peremption = $data['date_de_peremption'];
    }

    public function validate() {
        if (empty($this->id_produit) || $this->quantite <= 0 || empty($this->date_de_peremption)) {
            throw new Exception("Missing required fields or invalid data", 400);
        }
    }
}


?>
