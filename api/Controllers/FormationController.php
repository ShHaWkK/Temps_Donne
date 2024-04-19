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
                    if (!empty($uri[3])) {
                        if ($uri[3] === 'browse') {
                            $this->browseFormations();
                        } elseif ($uri[3] === 'my-formations' && !empty($uri[4])) {
                            $this->viewFormationsOfVolunteer($uri[4]);
                        } else {
                            $this->getFormation($uri[3]);
                        }
                    } else {
                        $this->getAllFormations();
                    }
                    break;
                case 'POST':
                    if (!empty($uri[3]) && $uri[3] === 'register') {
                        $this->registerFormationOfVolunteer();
                    } else {
                        $this->createFormation();
                    }
                    break;
                case 'PUT':
                    if (!empty($uri[3])) {
                        $this->updateFormation($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (!empty($uri[3]) && $uri[3] === 'unregister') {
                        $this->unregisterFormationOfVolunteer();
                    } else if (!empty($uri[3])) {
                        $this->deleteFormation($uri[3]);
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

    //------------------------ Get All Formations ------------------------//s

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

    //------------------------ Get Formation ------------------------//
    

    public function getFormation($id) {
        $formation = $this->formationService->getFormationDetails($id);
        if (!$formation) {
            ResponseHelper::sendNotFound("ICI : Formation not found.");
        } else {
            ResponseHelper::sendResponse($formation);
        }
    }


    //------------------------ Create Formation ------------------------//

    public function createFormation() {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->formationService->addFormation($data);
        if ($result) {
            ResponseHelper::sendResponse("Formation created successfully", 201);
        } else {
            ResponseHelper::sendResponse("Failed to create formation", 400);
        }
    }

    //------------------------ Update Formation ------------------------//s

    public function updateFormation($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->formationService->updateFormation($id, $data);
        if ($result) {
            ResponseHelper::sendResponse("Formation updated successfully");
        } else {
            ResponseHelper::sendNotFound("Failed to update formation or formation not found");
        }
    }

    //------------------------ Delete Formation ------------------------//

    public function deleteFormation($id) {
        $result = $this->formationService->deleteFormation($id);
        if ($result) {
            ResponseHelper::sendResponse("Formation deleted successfully");
        } else {
            ResponseHelper::sendNotFound("Formation not found");
        }
    }


    //------------------------ Volunteer Registration ------------------------//

    public function registerFormationOfVolunteer() {
        $data = json_decode(file_get_contents("php://input"), true);
        // Assuming $data contains 'volunteerId' and 'formationId'
        $result = $this->formationService->registerVolunteerForFormation($data['volunteerId'], $data['formationId']);
        if ($result) {
            ResponseHelper::sendResponse("Volunteer registered successfully", 201);
        } else {
            ResponseHelper::sendResponse("Failed to register volunteer", 400);
        }
    }

    //------------------------ Volunteer Unregistration ------------------------//

    public function unregisterFormationOfVolunteer() {
        $data = json_decode(file_get_contents("php://input"), true);
        // Assuming $data contains 'volunteerId' and 'formationId'
        $result = $this->formationService->unregisterVolunteerFromFormation($data['volunteerId'], $data['formationId']);
        if ($result) {
            ResponseHelper::sendResponse("Volunteer unregistered successfully");
        } else {
            ResponseHelper::sendNotFound("Failed to unregister volunteer or volunteer not found");
        }
    }


    public function browseFormations() {
        $formations = $this->formationService->listAllFormations();
        ResponseHelper::sendResponse($formations);
    }

    public function viewFormationsOfVolunteer($volunteerId) {
        $formations = $this->formationService->getFormationsForVolunteer($volunteerId);
        ResponseHelper::sendResponse($formations);
    }

}
