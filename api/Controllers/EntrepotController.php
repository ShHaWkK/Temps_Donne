<?php
require_once './Services/EntrepotService.php';
require_once './Helpers/ResponseHelper.php';

class EntrepotController {
    private $entrepotService;

    public function __construct() {
        $db = connectDB();
        $entrepotRepository = new EntrepotRepository($db);
        $this->entrepotService = new EntrepotService($entrepotRepository);
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

    public function updateEntrepot($id, $data) {
        try {
            $this->entrepotService->updateEntrepot($id, $data);
            if (isset($data['volume_utilise'])) {
                $this->entrepotService->updateVolume($id, $data['volume_utilise']);
            }
            ResponseHelper::sendResponse(['message' => 'Entrepot updated successfully']);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], 500);
        }
    }


    public function createEntrepot($data) {
        $entrepot = new EntrepotModel($data);
        if ($this->validateEntrepot($entrepot)) {
            $id = $this->entrepotService->createEntrepot($entrepot);
            ResponseHelper::sendResponse(['message' => 'Entrepot created successfully', 'id' => $id], 201);
        } else {
            ResponseHelper::sendResponse(['error' => 'Validation failed for entrepot'], 400);
        }
    }


    private function validateEntrepot($entrepot) {
        // Validez ici selon vos critères
        return $entrepot->nom && $entrepot->adresse && is_numeric($entrepot->volumeTotal) && is_numeric($entrepot->volumeUtilise);
    }



    private function deleteEntrepot($id) {
        $this->entrepotService->deleteEntrepot($id);
        ResponseHelper::sendResponse(['message' => 'Entrepot deleted successfully']);
    }
}


?>
