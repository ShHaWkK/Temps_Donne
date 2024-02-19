<?php
// file: api/src/Services/StockService.php
require_once 'Repository/StockRepository.php';

class StockService 
{

    private $stockRepository;

    public function __construct($db) {
        $this->stockRepository = new StockRepository($db);
    }

    public function addStock($stockData) {
        return $this->stockRepository->addStock($stockData);
    }

    public function updateStock($id, $stockData) {
        $this->stockRepository->updateStock($id, $stockData);
    }

    public function deleteStock($id) {
        $this->stockRepository->deleteStock($id);
    }

    public function getStock($id) {
        return $this->stockRepository->getStockById($id);
    }

    public function getAllStocks() {
        return $this->stockRepository->getAllStocks();
    }

    public function getStocksByType($type) {
        return $this->stockRepository->getStocksByType($type);
    }

    public function getStocksByLocation($location) {
        return $this->stockRepository->getStocksByLocation($location);
    }

    public function getStocksByUrgency($urgency) {
        return $this->stockRepository->getStocksByUrgency($urgency);
    }

    public function getStocksByDonation($donationId) {
        return $this->stockRepository->getStocksByDonation($donationId);
    }
    
}
?>