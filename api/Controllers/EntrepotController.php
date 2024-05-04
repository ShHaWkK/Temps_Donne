<?php
require_once './Services/EntrepotService.php';
require_once './Helpers/ResponseHelper.php';

class EntrepotController {
    private $entrepotService;

    public function __construct() {
        $db = connectDB();  // Assurez-vous que cette fonction retourne une instance de PDO
        $this->entrepotService = new EntrepotService(new EntrepotRepository($db));
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getEntrepot($uri[3]);
                    } else {
                        $this->getAllEntrepots();
                    }
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->createEntrepot($data);
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $data = json_decode(file_get_contents('php://input'), true);
                        $this->updateEntrepot($uri[3], $data);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteEntrepot($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendNotFound("Method not supported.");
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function getEntrepot($id) {
        $entrepot = $this->entrepotService->getEntrepotById($id);
        if (!$entrepot) {
            ResponseHelper::sendNotFound("Entrepot not found.");
        } else {
            ResponseHelper::sendResponse($entrepot);
        }
    }

    private function getAllEntrepots() {
        $entrepots = $this->entrepotService->getAllEntrepots();
        ResponseHelper::sendResponse($entrepots);
    }

    public function createEntrepot($data) {
        $entrepot = new EntrepotModel($data);
        $this->entrepotService->createEntrepot($entrepot);
        ResponseHelper::sendResponse(['message' => 'Entrepot created successfully'], 201);
    }

    private function updateEntrepot($id, $data) {
        $this->entrepotService->updateEntrepot($id, $data);
        ResponseHelper::sendResponse(['message' => 'Entrepot updated successfully']);
    }

    private function deleteEntrepot($id) {
        $this->entrepotService->deleteEntrepot($id);
        ResponseHelper::sendResponse(['message' => 'Entrepot deleted successfully']);
    }
}


?>
