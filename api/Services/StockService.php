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
        try {
            $existingStock = $this->repository->findById($id);
            if (!$existingStock) {
                throw new Exception("Stock not found with ID: $id", 404);
            }
            $updatedStock = new StockModel(array_merge($existingStock, $data));
            return $this->repository->save($updatedStock);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteStock($id) {
        try {
            return $this->repository->delete($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function addStock(StockModel $stock) {
        $stockId = $this->repository->save($stock);
        $stock->id_stock = $stockId;
        $this->generateQrCode($stock);
        return $stockId;
    }

    //-------------------------- QR code --------------------------//

    private function generateQrCode(StockModel $stock) {
        $qrCode = new QrCode(json_encode([
            'id_stock' => $stock->id_stock,
            'type_article' => $stock->type_article,
            'emplacement' => $stock->emplacement, 
            'quantite' => $stock->quantite,
            'date_de_peremption' => $stock->date_de_peremption,
        ], JSON_UNESCAPED_UNICODE));
    
        $writer = new PngWriter();
        $qrCodePath = __DIR__ . '/../qr_codes/' . $stock->id_stock . '.png';
        $writer->write($qrCode)->saveToFile($qrCodePath);
        
        // Sauvegarder le chemin du QR Code dans le modèle
        $stock->qr_code = $qrCodePath;
        
        // Mettre à jour le stock avec le chemin du QR code
        $this->repository->updateQrCodePath($stock->id_stock, $qrCodePath);
    }
    
}

?>
