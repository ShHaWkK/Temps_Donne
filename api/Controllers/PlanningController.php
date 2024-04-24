<?php
require_once './Repository/UserRepository.php';
require_once './Services/PlanningService.php';
require_once './Models/PlanningModel.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';

class PlanningController {
    private $planningService;
    private $userRepository;

    public function __construct() {
        $db = connectDB();
        $planningRepository = new PlanningRepository($db);
        $this->userRepository = new UserRepository($db);
        $this->planningService = new PlanningService($planningRepository, $this->userRepository);
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getPlanning($uri[3]);
                    } else {
                        $this->getAllPlannings();
                    }
                    break;
                case 'POST':
                    // Assurez-vous que l'index 3 existe et qu'il contient la chaîne 'planning'
                    if (isset($uri[3]) && $uri[3] === 'planning'){
                        $this->addPlanning();
                    }
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updatePlanning($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deletePlanning($uri[3]);
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


    public function getPlanning($id) {
        $planning = $this->planningService->getPlanning($id);
        if (!$planning) {
            ResponseHelper::sendNotFound("Planning not found.");
        } else {
            ResponseHelper::sendResponse($planning);
        }
    }

    public function getAllPlannings() { 
        $plannings = $this->planningService->getAllPlannings();
        ResponseHelper::sendResponse($plannings);
    }
    

    //-------------------- Add Planning -------------------//

    public function addPlanning() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $userId = $data['ID_Utilisateur'] ?? null;
            if (!$userId || !$this->userRepository->findById($userId)) {
                throw new Exception("Invalid user ID");
            }

            $planning = new PlanningModel($data);
            $this->planningService->addPlanning($planning);
            //ResponseHelper::sendResponse(["success" => "Planning added successfully."], 201);
            exit_with_message("Planning added successfully.");
        } catch (Exception $e) {
            exit_with_message($e->getMessage(), 500);
        }
    }
    
    public function updatePlanning($id) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            // Mettre à jour le planning existant
            $this->planningService->updatePlanning($id, $data);
            ResponseHelper::sendResponse(["success" => "Planning updated successfully."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    public function deletePlanning($id) {
        try {
            $this->planningService->deletePlanning($id);
            ResponseHelper::sendResponse(["success" => "Planning deleted successfully."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }
    
    //-------------------- Assign Volunteer to Service -------------------//
    public function assignVolunteerToService() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
    
        try {
            $userId = $data['userId'];
            $serviceId = $data['serviceId'];
            $dateTime = $data['dateTime'];
    
            $this->planningService->assignVolunteerToService($userId, $serviceId, $dateTime);
            ResponseHelper::sendResponse(["success" => "Volunteer assigned to service successfully."], 201);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Remove Volunteer from Service -------------------//
    public function removeVolunteerFromService() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
    
        try {
            $userId = $data['userId'];
            $serviceId = $data['serviceId'];
            $dateTime = $data['dateTime'];
    
            $this->planningService->removeVolunteerFromService($userId, $serviceId, $dateTime);
            ResponseHelper::sendResponse(["success" => "Volunteer removed from service successfully."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Get Volunteer Services -------------------//
    public function getVolunteerServices($userId) {
        $services = $this->planningService->getVolunteerServices($userId);
        ResponseHelper::sendResponse($services);
    }
    //-------------------- obtenir tous les plannings d'un bénévole spécifique -------------------//

    public function getPlanningsForVolunteer($userId) {
        try {
            $plannings = $this->planningService->getPlanningsForVolunteer($userId);
            ResponseHelper::sendResponse($plannings);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- obtenir le planning d'un bénévole à une date spécifique -------------------//

    public function getPlanningByDate($userId, $date) {
        try {
            $planning = $this->planningService->getPlanningByDate($userId, $date);
            if (!$planning) {
                ResponseHelper::sendNotFound("No planning found for this date.");
            } else {
                ResponseHelper::sendResponse($planning);
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }
    
    
    
}
/*
// Récupération de la méthode et des segments d'URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Création et traitement de la requête
$controller = new PlanningController();
$controller->processRequest($method, $uri);
*/
?>
