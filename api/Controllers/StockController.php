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

    private function addStock() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $stock = new StockModel($data);
            $this->stockService->addStock($stock);
            ResponseHelper::sendResponse(["success" => "Stock added successfully."], 201);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
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

// Récupération de la méthode et des segments d'URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Création et traitement de la requête
$controller = new StockController();
$controller->processRequest($method, $uri);
?>
