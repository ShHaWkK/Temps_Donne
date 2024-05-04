<?php

require_once './Repository/StockRepository.php';
require_once './Repository/ProduitRepository.php';
require_once './Repository/EntrepotRepository.php'; 
require_once './Models/StockModel.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class StockService {
    private $stockRepository;
    private $entrepotRepository;
    private $produitRepository;

    public function __construct(StockRepository $stockRepository, EntrepotRepository $entrepotRepository, ProduitRepository $produitRepository) {
        $this->stockRepository = $stockRepository;
        $this->entrepotRepository = $entrepotRepository;
        $this->produitRepository = $produitRepository;
    }
    public function addStock($stockData) {
        try {
            $entrepot = $this->entrepotRepository->findById($stockData['id_entrepot']);
            $produit = $this->produitRepository->findById($stockData['id_produit']);

            if (!$entrepot || !$produit) {
                throw new Exception("Entrepôt ou produit introuvable.");
            }

            $volumeRequired = $stockData['quantite'] * $produit['volume'];
            if (($entrepot['volume_total'] - $entrepot['volume_utilise']) < $volumeRequired) {
                throw new Exception("Volume insuffisant dans l'entrepôt.");
            }

            $stock = new StockModel($stockData);
            $stock->validate();
            $stockId = $this->stockRepository->save($stock);

            $this->entrepotRepository->updateVolume($entrepot['id'], $entrepot['volume_utilise'] + $volumeRequired);
            $this->generateQrCode($stock);

            return $stockId;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception("Erreur de base de données lors de l'ajout du stock.");
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
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

        throw new Exception("Pas assez d'espace dans l'entrepôt pour le stock.");
    }


    private function generateQrCode(StockModel $stock) {
        $data = [
            'id_stock' => $stock->id_stock,
            'quantite' => $stock->quantite,
            'date_de_peremption' => $stock->date_de_peremption
        ];
        $qrCode = new QrCode(json_encode($data));
        $writer = new PngWriter();
        $qrCodePath = __DIR__ . '/../qr_codes/' . $stock->id_stock . '.png';
        $writer->write($qrCode)->saveToFile($qrCodePath);
        $stock->qr_code = $qrCodePath;

        // Mettre à jour le chemin du code QR dans la base de données.
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
