<?php

require_once './Services/CamionService.php';
require_once './Helpers/ResponseHelper.php';

class CamionController {
    private $camionService;

    public function __construct() {
        $this->camionService = new CamionService(new CamionRepository());
    }

    public function processRequest($method, $uri) {
        switch ($method) {
            case 'GET':
                if (isset($uri[3])) {
                    $this->getCamion($uri[3]);
                } else {
                    $this->getAllCamions();
                }
                break;
            case 'POST':
                $this->createCamion();
                break;
            case 'PUT':
                if (isset($uri[3])) {
                    $this->updateCamion($uri[3]);
                }
                break;
            case 'DELETE':
                if (isset($uri[3])) {
                    $this->deleteCamion($uri[3]);
                }
                break;
            default:
                ResponseHelper::sendNotFound("Method not supported.");
                break;
        }
    }

    private function getCamion($id) {
        $camion = $this->camionService->getCamionById($id);
        if (!$camion) {
            ResponseHelper::sendNotFound("Camion not found.");
        } else {
            ResponseHelper::sendResponse($camion);
        }
    }

    private function getAllCamions() {
        $camions = $this->camionService->getAllCamions();
        ResponseHelper::sendResponse($camions);
    }

    private function createCamion() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $this->camionService->saveCamion($data);
        ResponseHelper::sendResponse(['message' => 'Camion created successfully', 'id' => $id], 201);
    }

    private function updateCamion($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->camionService->saveCamion(array_merge(['id_camion' => $id], $data));
        ResponseHelper::sendResponse(['message' => 'Camion updated successfully']);
    }

    private function deleteCamion($id) {
        $this->camionService->deleteCamion($id);
        ResponseHelper::sendResponse(['message' => 'Camion deleted successfully']);
    }
}
?>