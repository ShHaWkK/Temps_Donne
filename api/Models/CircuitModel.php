<?php

require_once 'vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class CircuitModel {
    public $id;
    public $route;
    public $collectionTime;
    public $driverId;
    public $partnerMerchants;
    public $qr_code;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->route = $data['route'] ?? [];
        $this->collectionTime = $data['collectionTime'] ?? '';
        $this->driverId = $data['driverId'] ?? null;
        $this->partnerMerchants = $data['partnerMerchants'] ?? [];
        $this->qr_code = $data['qr_code'] ?? null;
    }

    public function validate() {
        if (empty($this->route) || empty($this->collectionTime) || empty($this->driverId) || empty($this->partnerMerchants)) {
            throw new Exception("Missing required fields", 400);
        }
        if (!is_array($this->route)) {
            throw new Exception("Route must be an array", 400);
        }
        if (!is_string($this->collectionTime)) {
            throw new Exception("Collection time must be a string", 400);
        }
        if (!is_numeric($this->driverId)) {
            throw new Exception("Driver ID must be a number", 400);
        }
        if (!is_array($this->partnerMerchants)) {
            throw new Exception("Partner merchants must be an array", 400);
        }
    }

    public function generateQrCode() {
        $data = [
            'id' => $this->id,
            'route' => $this->route,
            'collectionTime' => $this->collectionTime,
            'driverId' => $this->driverId
        ];

        $qrCode = new QrCode(json_encode($data));
        $writer = new PngWriter();
        $qrCodePath = '/path/to/qr/code/' . $this->id . '.png';

        $writer->write($qrCode)->saveToFile($qrCodePath);
        $this->qr_code = $qrCodePath;
    }
}
