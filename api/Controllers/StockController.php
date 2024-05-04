<?php

require_once './Repository/StockRepository.php';
require_once './Services/StockService.php';
require_once './Models/StockModel.php';
require_once './Helpers/ResponseHelper.php';

class StockController {
    private $stockService;

    public function __construct() {
        $db = connectDB();
        $stockRepository = new StockRepository($db);
        $this->stockService = new StockService($stockRepository);
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3]) && is_numeric($uri[3])) {
                        $this->getStock($uri[3]);
                    } else if (isset($uri[3]) && $uri[3] === 'filter') {
                        // Handling GET request with filters
                        $filters = $_GET; // Assuming you're passing filters as query parameters
                        $this->getStocksByCriteria($filters);
                    } else {
                        $this->getAllStocks();
                    }
                    break;
                case 'POST':
                    $this->addStock();
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateStock($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteStock($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendMethodNotAllowed("HTTP method not supported.");
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function getStock($id) {
        $stock = $this->stockService->getStockById($id);
        if (!$stock) {
            ResponseHelper::sendNotFound("Stock not found.");
        } else {
            ResponseHelper::sendResponse($stock);
        }
    }

    private function getAllStocks() {
        $stocks = $this->stockService->getAllStocks();
        ResponseHelper::sendResponse($stocks);
    }

    private function getStocksByCriteria($criteria) {
        $stocks = $this->stockService->getStocksByCriteria($criteria);
        ResponseHelper::sendResponse($stocks);
    }

    private function addStock() {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $stock = new StockModel($data);
            $stock->validate();
            $id = $this->stockService->addStock($stock);
            ResponseHelper::sendResponse(['message' => 'Stock added successfully', 'id' => $id], 201);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function updateStock($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        try {
            $this->stockService->updateStock($id, $data);
            ResponseHelper::sendResponse(['message' => "Stock updated successfully."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function deleteStock($id) {
        try {
            $this->stockService->deleteStock($id);
            ResponseHelper::sendResponse(['message' => "Stock deleted successfully."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
?>
