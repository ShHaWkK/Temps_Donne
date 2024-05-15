<?php
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';
require_once './Services/FormationService.php';
require_once './Models/FormationModel.php';

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
                        switch ($uri[3]) {
                            case 'browse':
                                $this->browseFormations();
                                break;
                            case 'inscriptions':
                                $this->getAllInscriptions();
                                break;
                            case 'my-formations':
                                $this->viewFormationsOfVolunteer($uri[4]);
                                break;
                            case 'registrations':
                                $this->getRegistrationsForFormation($uri[4]);
                                break;
                            case 'reports':
                                $this->generateReports();
                                break;
                            case 'available-formations':
                                $this->browseAvailableFormations();
                                break;
                            case 'sessions':
                                $this->getAllSessionsForUser($uri[4]);
                                break;
                            case 'formation-sessions':
                                $this->getAllFormationSessions($uri[4]);
                                break;
                            case 'upcoming-sessions':
                                $this->getUpcomingSessionsForFormation($uri[4]);
                                break;
                            case 'session-room':
                                $this->getSessionRoom($uri[4]);
                                break;
                            case 'rooms':
                                $this->getAllRooms();
                                break;
                            default:
                                $this->getFormation($uri[3]);
                                break;
                        }
                    } else {
                        $this->getAllFormations();
                    }
                    break;
                case 'POST':
                    if (!empty($uri[3])) {
                        switch ($uri[3]) {
                            case 'register':
                                $this->registerFormationOfVolunteer();
                                break;
                            case 'feedback':
                                $this->submitFeedback();
                                break;
                            case 'sessions':
                                $this->addSession();
                                break;
                            default:
                                $this->createFormation();
                                break;
                        }
                    } else {
                        ResponseHelper::sendResponse("Bad request", 400);
                    }
                    break;
                case 'PUT':
                    if (!empty($uri[3])) {
                        switch ($uri[3]) {
                            case 'validate-attendance':
                                $this->validateAttendance($uri[4], $uri[5]);
                                break;
                            case 'reject-attendance':
                                $this->rejectAttendance($uri[4], $uri[5]);
                                break;
                            case 'putOnHold-attendance':
                                $this->putOnHoldAttendance($uri[4], $uri[5]);
                                break;
                        }
                    } else if (!empty($uri[3])) {
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

    //------------------------ Get All Formations ------------------------//

    public function getAllFormations() {
        $formations = $this->formationService->listAllFormations();
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
            ResponseHelper::sendNotFound("Formation not found.");
        } else {
            ResponseHelper::sendResponse($formation);
        }
    }

    //------------------------ Create Formation ------------------------//

    public function createFormation() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            ResponseHelper::sendResponse("Invalid data", 400);
            return;
        }
        try {
            $result = $this->formationService->addFormation($data);
            if ($result) {
                ResponseHelper::sendResponse("Formation created successfully", 201);
            } else {
                ResponseHelper::sendResponse("Failed to create formation", 400);
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], 400);
        }
    }

    //------------------------ Update Formation ------------------------//

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

    //------------------------ Administer Formation ------------------------//

    public function getRegistrationsForFormation($formationId) {
        $registrations = $this->formationService->getRegistrationsForFormation($formationId);
        ResponseHelper::sendResponse($registrations);
    }

    public function validateAttendance($userId, $formationId) {
        try {
            $result = $this->formationService->validateAttendance($userId, $formationId);
            if ($result) {
                ResponseHelper::sendResponse("Attendance validated successfully");
            } else {
                ResponseHelper::sendNotFound("Failed to validate attendance");
            }
        } catch(Exception $e) {
            ResponseHelper::sendResponse("Erreur lors de la validation de la présence : " . $e->getMessage());
        }
    }


    public function generateReports() {
        $reports = $this->formationService->generateReports();
        ResponseHelper::sendResponse($reports);
    }

    //------------------------ Volunteer Registration ------------------------//

    public function registerFormationOfVolunteer() {
        $data = json_decode(file_get_contents("php://input"), true);
        try {
            $result = $this->formationService->registerVolunteerForFormation($data['volunteerId'], $data['formationId']);
            if ($result) {
                ResponseHelper::sendResponse("Volunteer registered successfully", 201);
            } else {
                ResponseHelper::sendResponse("Failed to register volunteer", 400);
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], 400);
        }
    }

    //------------------------ Volunteer Unregistration ------------------------//

    public function unregisterFormationOfVolunteer() {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->formationService->unregisterVolunteerFromFormation($data['volunteerId'], $data['formationId']);
        if ($result) {
            ResponseHelper::sendResponse("Volunteer unregistered successfully");
        } else {
            ResponseHelper::sendNotFound("Failed to unregister volunteer or volunteer not found");
        }
    }

    //------------------------ Browse Formations ------------------------//

    public function browseFormations() {
        $formations = $this->formationService->listAllFormations();
        ResponseHelper::sendResponse($formations);
    }

    //------------------------ View Formations of Volunteer ------------------------//

    public function viewFormationsOfVolunteer($volunteerId) {
        $formations = $this->formationService->getFormationsForVolunteer($volunteerId);
        ResponseHelper::sendResponse($formations);
    }

    //------------------------ Sessions ------------------------//

    public function getAllSessionsForUser($userId) {
        $sessions = $this->formationService->getAllSessionsForUser($userId);
        ResponseHelper::sendResponse($sessions);
    }

    public function getUpcomingSessionsForFormation($formationId) {
        $sessions = $this->formationService->getUpcomingSessionsForFormation($formationId);
        ResponseHelper::sendResponse($sessions);
    }

    //------------------------ Feedback ------------------------//

    public function submitFeedback() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            ResponseHelper::sendResponse("Invalid data", 400);
            return;
        }
        $result = $this->formationService->addFeedback($data);
        if ($result) {
            ResponseHelper::sendResponse("Feedback submitted successfully", 201);
        } else {
            ResponseHelper::sendResponse("Failed to submit feedback", 400);
        }
    }

    //------------------------ Browse Available Formations ------------------------//

    public function browseAvailableFormations() {
        $availableFormations = $this->formationService->getAvailableFormations();
        ResponseHelper::sendResponse($availableFormations);
    }

    private function getAllFormationSessions($formationId)
    {
        $sessions = $this->formationService->getAllFormationSessions($formationId);
        ResponseHelper::sendResponse($sessions);
    }

    private function getAllInscriptions()
    {
        $sessions = $this->formationService->getAllInscriptions();
        ResponseHelper::sendResponse($sessions);
    }

    private function rejectAttendance($userId, $formationId)
    {
        try {
            $result = $this->formationService->rejectAttendance($userId, $formationId);
            if ($result) {
                ResponseHelper::sendResponse("Attendance rejected successfully");
            } else {
                ResponseHelper::sendNotFound("Failed to reject attendance");
            }
        } catch(Exception $e) {
            ResponseHelper::sendResponse("Erreur lors de la validation de la présence : " . $e->getMessage());
        }
    }

    private function putOnHoldAttendance($userId, $formationId)
    {
        try {
            $result = $this->formationService->putOnHoldAttendance($userId, $formationId);
            if ($result) {
                ResponseHelper::sendResponse("Attendance put on hold successfully");
            } else {
                ResponseHelper::sendNotFound("Failed to put on hold attendance");
            }
        } catch(Exception $e) {
            ResponseHelper::sendResponse("Erreur lors de la validation de la présence : " . $e->getMessage());
        }
    }

    private function getSessionRoom($roomId)
    {
        try {
            $result = $this->formationService->getSessionRoom($roomId);
            if ($result) {
                ResponseHelper::sendResponse($result);
            } else {
                ResponseHelper::sendNotFound("Not found");
            }
        } catch(Exception $e) {
            ResponseHelper::sendResponse("Error: " . $e->getMessage());
        }
    }

    private function getAllRooms()
    {
        try {
            $result = $this->formationService->getAllRooms();
            if ($result) {
                ResponseHelper::sendResponse($result);
            } else {
                ResponseHelper::sendNotFound("Not found");
            }
        } catch(Exception $e) {
            ResponseHelper::sendResponse("Error: " . $e->getMessage());
        }
    }

    private function addSession()
    {        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $result = $this->formationService->addSession($data);
            ResponseHelper::sendResponse("Session added successfully");
        } catch(Exception $e) {
            ResponseHelper::sendResponse("Error: " . $e->getMessage());
        }
    }

}
