<?php

require_once './Repository/StockRepository.php';
require_once './Models/StockModel.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class StockService {
    private $repository;

    public function __construct(StockRepository $repository) {
        $this->repository = $repository;
    }

    public function getAllStocks() {
        return $this->repository->findAll();
    }

    public function getStockById($id) {
        return $this->repository->findById($id);
    }

    public function updateStock($id, $data) {
        $existingStock = $this->repository->findById($id);
        if (!$existingStock) {
            throw new Exception("Stock not found with ID: $id", 404);
        }
        $updatedStock = new StockModel(array_merge($existingStock, $data));
        $updatedStock->validate();
        $this->repository->save($updatedStock);
        return $updatedStock->id;
    }

    public function deleteStock($id) {
        return $this->repository->delete($id);
    }

    public function addStock(StockModel $stock) {
        $stock->validate();
        $stockId = $this->repository->save($stock);
        $this->generateQrCode($stock);
        return $stockId;
    }

    private function generateQrCode(StockModel $stock) {
        $data = [
            'id_stock' => $stock->id_stock,
            'id_produit' => $stock->id_produit,
            'quantite' => $stock->quantite,
            'poids_total' => $stock->poids_total,
            'volume_total' => $stock->volume_total,
            'date_de_peremption' => $stock->date_de_peremption,
            'date_de_reception' => $stock->date_de_reception,
            'statut' => $stock->statut
        ];

        $qrCode = new QrCode(json_encode($data, JSON_UNESCAPED_UNICODE));
        $writer = new PngWriter();
        $qrCodePath = __DIR__ . '/../qr_codes/' . $stock->id_stock . '.png';
        $writer->write($qrCode)->saveToFile($qrCodePath);

        $stock->qr_code = $qrCodePath;
        $this->repository->updateQrCodePath($stock->id_stock, $qrCodePath);
    }

    public function updateQrCodePath($stockId, $qrCodePath) {
        $sql = "UPDATE Stocks SET QR_Code = :qr_code WHERE ID_Stock = :id_stock";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':qr_code' => $qrCodePath,
            ':id_stock' => $stockId
        ]);
    }
}



?>
