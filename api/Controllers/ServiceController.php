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

    public function processRequest($method, $uri)
    {
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

        error_log(print_r($data, true));

        try {
            $service = new ServiceModel($data);

            $this->serviceService->createService($service);

            ResponseHelper::sendResponse(["success" => "Inscription du bénévole réussie. En attente de validation."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    private function updateService($id)
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            ResponseHelper::sendResponse(["error" => "Invalid JSON: " . json_last_error_msg()], 400);
            return;
        }

        try {
            $fieldsToUpdate = array_keys($data);
            $service = $this->serviceService->getServiceById($id);

            // Mettre à jour les champs spécifiques
            foreach ($fieldsToUpdate as $field) {
                $service->$field = $data[$field];
            }

            $this->serviceService->updateService($service, $fieldsToUpdate);
            ResponseHelper::sendResponse(["success" => "Service mis à jour avec succès."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
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