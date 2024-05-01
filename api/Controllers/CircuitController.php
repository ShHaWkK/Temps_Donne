<?php
require_once './Services/CircuitService.php';
require_once './Models/CircuitModel.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';

class CircuitController {
    private $circuitService;

    public function __construct() {
        $db = connectDB();
        $circuitRepository = new CircuitRepository($db);
        $this->circuitService = new CircuitService($circuitRepository);
    }

  // CircuitController.php

public function processRequest($method, $uri) {
    try {
        switch ($method) {
            case 'GET':
                // GET requests
                if (isset($uri[3])) {
                    switch ($uri[2]) {
                        case 'date':
                            $this->findByDate($uri[3]);
                            break;
                        case 'chauffeur':
                            $this->findByChauffeur($uri[3]);
                            break;
                        case 'planRoute':
                            // Ensure that the necessary parameters are present
                            if (isset($_GET['start']) && isset($_GET['end'])) {
                                $this->planRoute($_GET['start'], $_GET['end']);
                            } else {
                                ResponseHelper::sendNotFound("Start or end point missing.");
                            }
                            break;
                        default:
                            $this->getCircuit($uri[3]);
                            break;
                    }
                } else {
                    $this->getAllCircuits();
                }
                break;
            case 'POST':
                // POST requests
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($uri[2]) && $uri[2] == 'planRoute') {
                    $this->planRoute($data); // Assuming $data has the necessary 'start' and 'end' points
                } else {
                    $this->createCircuit($data);
                }
                break;
            case 'PUT':
                // PUT requests
                if (isset($uri[3])) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->updateCircuit($uri[3], $data);
                }
                break;
            case 'DELETE':
                // DELETE requests
                if (isset($uri[3])) {
                    $this->deleteCircuit($uri[3]);
                }
                break;
            default:
                // Method not supported
                ResponseHelper::sendNotFound("Method not supported.");
                break;
        }
    } catch (Exception $e) {
        ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
    }
}


    //--------------------------- Récupérer un circuit ---------------------------//
    private function getCircuit($id) {
        $circuit = $this->circuitService->findByID($id);
        if (!$circuit) {
            ResponseHelper::sendNotFound("Circuit not found.");
        } else {
            ResponseHelper::sendResponse($circuit);
        }
    }
    //--------------------------- Récupérer tous les circuits ---------------------------//
    private function getAllCircuits() {
        $circuits = $this->circuitService->findAll();
        ResponseHelper::sendResponse($circuits);
    }

    //--------------------------- Créer un circuit ---------------------------//
    private function createCircuit() {
        $data = json_decode(file_get_contents('php://input'), true);
        $circuit = new CircuitModel($data);
        $this->circuitService->create($circuit);
        ResponseHelper::sendResponse(['message' => 'Circuit created successfully'], 201);
    }

    //--------------------------- Mettre à jour un circuit ---------------------------//
    private function updateCircuit($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->circuitService->update($id, $data);
        ResponseHelper::sendResponse(['message' => 'Circuit updated successfully']);
    }

    //--------------------------- Supprimer un circuit ---------------------------//
    private function deleteCircuit($id) {
        $this->circuitService->delete($id);
        ResponseHelper::sendResponse(['message' => 'Circuit deleted successfully']);
    }

    //--------------------------- Trouver un circuit par date ---------------------------//
    public function findAll() {
        $circuits = $this->circuitService->findAll();
        ResponseHelper::sendResponse($circuits);
    }

    //--------------------------- Trouver un circuit par date ---------------------------//
    public function findByDate($date) {
        $circuits = $this->circuitService->findByDate($date);
        if (!empty($circuits)) {
            ResponseHelper::sendResponse($circuits);
        } else {
            ResponseHelper::sendNotFound("Aucun circuit trouvé pour la date spécifiée.");
        }
    }

    //--------------------------- Trouver un circuit par chauffeur ---------------------------//
    public function findByChauffeur($chauffeurId) {
        $circuits = $this->circuitService->findByChauffeur($chauffeurId);
        if (!empty($circuits)) {
            ResponseHelper::sendResponse($circuits);
        } else {
            ResponseHelper::sendNotFound("Aucun circuit trouvé pour le chauffeur spécifié.");
        }
    }

    //--------------------------- Plan de Route ---------------------------//

    public function planRoute($requestData) {
        try {
            $startPoint = $requestData['start'];
            $endPoint = $requestData['goal'];
            $optimizedRoute = $this->circuitService->planRoute($startPoint, $endPoint);
            ResponseHelper::sendResponse(['route' => $optimizedRoute]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

}
