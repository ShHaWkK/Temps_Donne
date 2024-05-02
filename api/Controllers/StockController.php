<?php

require_once './Repository/StockRepository.php';
require_once './Services/StockService.php';
require_once './Models/StockModel.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';

class StockController {
    private $stockService;

    public function __construct() {
        $db = connectDB();
        $stockRepository = new StockRepository($db);
        $this->stockService = new StockService($stockRepository);
    }

    //---------------------------   ---------------------------//
    public function processRequest($method, $uri) {
        var_dump($method);
        var_dump($uri);
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getStock($uri[3]);
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
                    ResponseHelper::sendMethodNotAllowed();
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    //---------------------------   ---------------------------//

    private function getStock($id) {
        $stock = $this->stockService->getStockById($id);
        var_dump($stock); // Inspecter l'objet stock
        if (!$stock) {
            ResponseHelper::sendNotFound("Stock not found.");
        } else {
            ResponseHelper::sendResponse($stock);
        }
    }

    //---------------------------   ---------------------------//

    private function getAllStocks() {
        $stocks = $this->stockService->getAllStocks();
        ResponseHelper::sendResponse($stocks);
    }

    //---------------------------   ---------------------------//

    public function addStock() {
        $data = json_decode(file_get_contents('php://input'), true);
        var_dump($data); // Voir les données reçues
        try {
            $stock = new StockModel($data);
            $stock->validate();
            $id = $this->stockService->addStock($stock);
            ResponseHelper::sendResponse(['message' => 'Stock added successfully', 'id' => $id], 201);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    //---------------------------   ---------------------------//

    private function updateStock($id) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $this->stockService->updateStock($id, $data);
            ResponseHelper::sendResponse(["success" => "Stock updated successfully."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //---------------------------   ---------------------------//

    private function deleteStock($id) {
        try {
            $this->stockService->deleteStock($id);
            ResponseHelper::sendResponse(["success" => "Stock deleted successfully."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }
}

?>
