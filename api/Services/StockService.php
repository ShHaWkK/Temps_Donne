<?php

require_once './Repository/StockRepository.php';
require_once './Repository/EntrepotRepository.php'; // Assurez-vous d'inclure le bon fichier pour EntrepotRepository
require_once './Models/StockModel.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class StockService {
    private $stockRepository;
    private $entrepotRepository;

    public function __construct(StockRepository $stockRepository, EntrepotRepository $entrepotRepository) {
        $this->stockRepository = $stockRepository;
        $this->entrepotRepository = $entrepotRepository;
    }

    public function addStock($stockData) {
        $entrepot = $this->entrepotRepository->findById($stockData['id_entrepot']);
        $produit = $this->stockRepository->findProductById($stockData['id_produit']);

        $volumeRequired = $stockData['quantite'] * $produit['volume'];

        if ($entrepot['volume_total'] - $entrepot['volume_utilise'] < $volumeRequired) {
            return $this->handleInsufficientVolume($stockData, $entrepot, $volumeRequired);
        }

        $stock = new StockModel($stockData);
        $stockId = $this->stockRepository->save($stock);
        $this->entrepotRepository->updateVolume($entrepot['id'], $volumeRequired);
        $this->generateQrCode($stock);
        return $stockId;
    }

    public function updateStock($id, $data) {
        $existingStock = $this->getStockById($id);
        if (!$existingStock) {
            throw new Exception("Stock not found with ID: $id", 404);
        }
        $updatedData = array_merge($existingStock, $data);
        $updatedStock = new StockModel($updatedData);
        $updatedStock->validate(); // Assurez-vous que les données sont valides
        $this->repository->save($updatedStock);
        return $updatedStock;
    }

    private function handleInsufficientVolume($stockData, $entrepot, $volumeRequired) {
        $maxQuantitePossible = floor(($entrepot['volume_total'] - $entrepot['volume_utilise']) / $stockData['volume']);
        if ($maxQuantitePossible > 0) {
            $partialStockData = $stockData;
            $partialStockData['quantite'] = $maxQuantitePossible;
            $this->addStock($partialStockData);

            $remainingStockData = $stockData;
            $remainingStockData['quantite'] -= $maxQuantitePossible;
            return $this->addStock($remainingStockData);
        }

        throw new Exception("Not enough space available in any warehouses.");
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
        $this->stockRepository->updateQrCodePath($stock->id_stock, $qrCodePath);
    }

    public function updateQrCodePath($stockId, $qrCodePath) {
        $this->stockRepository->updateQrCodePath($stockId, $qrCodePath);
    }

    // Ajoutez ici les autres méthodes nécessaires pour gérer les stocks

    public function getStocksByCriteria($criteria) {
        return $this->repository->findByCriteria($criteria);
    }
}

?>
