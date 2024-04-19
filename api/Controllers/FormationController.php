<?php
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';
require_once './Services/FormationService.php';
require_once './Models/FormationModel.php';
require_once './Helpers/ResponseHelper.php';

class FormationController {
    private $formationService;

    public function __construct() {
        $db = connectDB(); 
        $formationRepository = new FormationRepository($db);
        $this->formationService = new FormationService($formationRepository);
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (!empty($uri[2])) {
                        $this->getFormation($uri[2]); 
                    } else {
                        $this->getAllFormations();
                    }
                    break;
                case 'POST':
                    $this->createFormation();
                    break;
                case 'PUT':
                    if (!empty($uri[2])) {
                        $this->updateFormation($uri[2]);
                    }
                    break;
                case 'DELETE':
                    if (!empty($uri[2])) {
                        $this->deleteFormation($uri[2]);
                    }
                    break;
                default:
                    ResponseHelper::sendResponse("Method Not Allowed", 405);
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllFormations() {
        $formations = $this->formationService->listAllFormations();
        var_dump();
        error_log(print_r($formations, true));
        if (!$formations) {
            ResponseHelper::sendNotFound("Formation not found.");
        } else {
            ResponseHelper::sendResponse($formations);
        }
    }
    

    public function getFormation($id) {
        $formation = $this->formationService->getFormationDetails($id);
        if (!$formation) {
            ResponseHelper::sendNotFound("ICI : Formation not found.");
        } else {
            ResponseHelper::sendResponse($formation);
        }
    }

    public function createFormation() {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->formationService->addFormation($data);
        if ($result) {
            ResponseHelper::sendResponse("Formation created successfully", 201);
        } else {
            ResponseHelper::sendResponse("Failed to create formation", 400);
        }
    }

    public function updateFormation($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->formationService->updateFormation($id, $data);
        if ($result) {
            ResponseHelper::sendResponse("Formation updated successfully");
        } else {
            ResponseHelper::sendNotFound("Failed to update formation or formation not found");
        }
    }

    public function deleteFormation($id) {
        $result = $this->formationService->deleteFormation($id);
        if ($result) {
            ResponseHelper::sendResponse("Formation deleted successfully");
        } else {
            ResponseHelper::sendNotFound("Formation not found");
        }
    }
}
