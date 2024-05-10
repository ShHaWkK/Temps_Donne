<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class CircuitModel {
    public $id_circuit;
    public $date_circuit;
    public $itineraire;
    public $id_chauffeur;
    public $qr_code;

    public function __construct($data) {
        $this->id_circuit = $data['ID_Circuit'] ?? null;
        $this->date_circuit = $data['Date_Circuit'] ?? '';
        $this->itineraire = $data['Itineraire'] ?? '';
        $this->id_chauffeur = $data['ID_Chauffeur'] ?? null;
        $this->qr_code = $data['QR_Code'] ?? null;
    }

    public function validate() {
        if (empty($this->date_circuit) || empty($this->itineraire) || empty($this->id_chauffeur)) {
            throw new Exception("Missing required fields", 400);
        }
        if (!is_string($this->date_circuit)) {
            throw new Exception("Date Circuit must be a string", 400);
        }
        if (!is_string($this->itineraire)) {
            throw new Exception("Itineraire must be a string", 400);
        }
        if (!is_numeric($this->id_chauffeur)) {
            throw new Exception("Chauffeur ID must be a number", 400);
        }
    }

    public function generateQrCode() {
        // Données à encoder dans le QR code
        $data = [
            'id_circuit' => $this->id_circuit,
            'date_circuit' => $this->date_circuit,
            'itineraire' => $this->itineraire,
            'id_chauffeur' => $this->id_chauffeur
        ];

        // Créer le QR code
        $qrCode = new QrCode(json_encode($data));
        $writer = new PngWriter();

        // Spécifier le chemin où enregistrer le QR code
        $qrCodeDirectory = '/mnt/data/qr_codes/';
        if (!file_exists($qrCodeDirectory)) {
            mkdir($qrCodeDirectory, 0777, true);
        }
        $qrCodePath = $qrCodeDirectory . $this->id_circuit . '.png';

        // Sauvegarder le QR code en fichier PNG
        $writer->write($qrCode)->saveToFile($qrCodePath);

        // Mettre à jour le chemin du QR code dans le modèle
        $this->qr_code = $qrCodePath;
    }
}
