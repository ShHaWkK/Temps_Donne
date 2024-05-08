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
        $this->id_stock = $data['ID_Stock'] ?? null;
        $this->id_entrepot = $data['ID_Entrepots'];
        $this->id_produit = $data['ID_Produit'];
        $this->quantite = $data['Quantite'];
        $this->poids_total = $data['Poids_Total'];
        $this->volume_total = $data['Volume_Total'];
        $this->date_de_reception = $data['Date_de_reception'];
        $this->statut = $data['Statut'] ?? 'en_route';
        $this->qr_code = $data['QR_Code'] ?? null;
        $this->date_de_peremption = $data['Date_de_peremption'];
    }

    public function validate() {
        if (empty($this->id_produit) || $this->quantite <= 0 || empty($this->date_de_peremption)) {
            throw new Exception("Missing required fields or invalid data", 400);
        }
        // Validation supplémentaire pour les niveaux de stock
    }

    // Générer un code QR pour chaque stock
    public function generateQrCode() {
        $data = [
            'id_stock' => $this->id_stock,
            'quantite' => $this->quantite,
            'date_de_peremption' => $this->date_de_peremption
        ];
        $qrCode = new QrCode(json_encode($data));
        $writer = new PngWriter();
        $this->qr_code = '/path/to/qr/code/' . $this->id_stock . '.png';
        $writer->write($qrCode)->saveToFile($this->qr_code);
    }

    // Alertes pour le niveau de stock
    public function checkStockLevels() {
        if ($this->quantite < 10) {  // Niveau seuil pour exemple
            // Envoyer une alerte
        }
    }
}



?>
