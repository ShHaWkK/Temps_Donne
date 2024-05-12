<?php 

require_once './Repository/CommercantRepository.php';
require_once './Repository/BDD.php';
require_once './Services/CommercantService.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';


class CommercantController {
    private $commercantService;

    public function __construct() {
        $db = connectDB(); 
        $commercantRepository = new CommercantRepository($db);
        $this->commercantService = new CommercantService($commercantRepository);
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getCommercant($uri[3]);
                    } else {
                        $this->getAllCommercants();
                    }
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->createOrUpdateCommercant($data);
                    break;
                case 'PUT':
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (isset($uri[3])) {
                        $this->createOrUpdateCommercant($data, $uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteCommercant($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendMethodNotAllowed("HTTP method not supported.");
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function getCommercant($id) {
        $commercant = $this->commercantService->getCommercantById($id);
        if (!$commercant) {
            ResponseHelper::sendNotFound("Commercant not found.");
        } else {
            ResponseHelper::sendResponse($commercant);
        }
    }

    private function getAllCommercants() {
        $commercants = $this->commercantService->getAllCommercants();
        ResponseHelper::sendResponse($commercants);
    }

    private function createOrUpdateCommercant($data, $id = null) {
        if ($id) $data['id'] = $id;
        $result = this->commercantService->createOrUpdateCommercant($data);
        ResponseHelper::sendResponse(['message' => 'Commercant saved successfully', 'id' => $result], 201);
    }

    private function deleteCommercant($id) {
        $this->commercantService->deleteCommercant($id);
        ResponseHelper::sendResponse(['message' => 'Commercant deleted successfully']);
    }
}
?>