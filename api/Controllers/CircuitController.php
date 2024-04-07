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

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        switch ($uri[2]) {
                            case 'date':
                                $this->findByDate($uri[3]);
                                break;
                            case 'chauffeur':
                                $this->findByChauffeur($uri[3]);
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
                    $this->createCircuit();
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateCircuit($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteCircuit($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendNotFound();
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

}

// Récupération de la méthode et des segments d'URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Création et traitement de la requête
$controller = new CircuitController();
$controller->processRequest($method, $uri);
