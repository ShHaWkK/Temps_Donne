<?php

// file: api/src/Controllers/StockController.php
require_once '../Services/StockService.php';

class StockController {
    private $stockService;

    public function __construct($db) {
        $this->stockService = new StockService($db);
    }

    public function addStock() {
        $stockData = json_decode(file_get_contents("php://input"), true);
        $id = $this->stockService->addStock($stockData);
        http_response_code(201); // Created
        echo json_encode(['message' => 'Stock created successfully', 'id' => $id]);
    }

    public function updateStock($id) {
        $stockData = json_decode(file_get_contents("php://input"), true);
        $this->stockService->updateStock($id, $stockData);
        http_response_code(200); // OK
        echo json_encode(['message' => 'Stock updated successfully']);
    }

    public function deleteStock($id) {
        $this->stockService->deleteStock($id);
        http_response_code(200); // OK
        echo json_encode(['message' => 'Stock deleted successfully']);
    }

    public function getStock($id) {
        $stock = $this->stockService->getStock($id);
        if ($stock) {
            http_response_code(200); // OK
            echo json_encode($stock);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Stock not found']);
        }
    }

    public function getAllStocks() {
        $stocks = $this->stockService->getAllStocks();
        http_response_code(200); // OK
        echo json_encode($stocks);
    }
}
?>
