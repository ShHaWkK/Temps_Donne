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
        // Trouver l'entrepôt concerné pour vérifier le volume disponible.
        $entrepot = $this->entrepotRepository->findById($stockData['id_entrepot']);
        $produit = $this->stockRepository->findProductById($stockData['id_produit']);

        // Calculer le volume requis pour le nouveau stock.
        $volumeRequired = $stockData['quantite'] * $produit['volume'];

        // Vérifier s'il y a suffisamment de volume disponible dans l'entrepôt.
        if (($entrepot['volume_total'] - $entrepot['volume_utilise']) < $volumeRequired) {
            // Gérer le cas où il y a insuffisance de volume.
            return $this->handleInsufficientVolume($stockData, $entrepot, $volumeRequired);
        }

        // Créer un nouveau modèle de stock et l'enregistrer dans la base de données.
        $stock = new StockModel($stockData);
        $stock->validate();  // Validation pour assurer l'intégrité des données.
        $stockId = $this->stockRepository->save($stock);

        // Mettre à jour le volume utilisé dans l'entrepôt.
        $this->entrepotRepository->updateVolume($entrepot['id'], $entrepot['volume_utilise'] + $volumeRequired);

        // Générer un code QR pour le nouveau stock.
        $this->generateQrCode($stock);

        // Retourner l'ID du stock nouvellement ajouté.
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
