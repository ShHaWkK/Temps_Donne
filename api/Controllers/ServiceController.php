<?php

require_once './Services/ServiceService.php';
require_once './Models/ServiceModel.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';

class ServiceController {

    public $serviceService;

public function __construct() {
$db = connectDB();
$serviceRepository = new ServiceRepository($db);
$this->serviceService = new ServiceService($serviceRepository);
}

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getService($uri[3]);
                    } else {
                        $this->getAllServices();
                    }
                    break;
                case 'POST':
                        $this->createService();
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateService($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteService($uri[3]);
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

    private function createService()
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $service = new ServiceModel($data);

            ResponseHelper::sendResponse(["success" => "Le service a bien été créé."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    private function updateService(mixed $int)
    {
    }

    private function deleteService(mixed $int)
    {
    }

    private function getService(mixed $int)
    {
    }

    private function getAllServices()
    {
    }

}
?>