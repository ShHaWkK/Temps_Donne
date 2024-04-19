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
                        if ($uri[3] == 'type'){
                            if (isset($uri[4])){//id du type de service
                                if ($uri[4] == 'servicesByType') {
                                    $this->getServicesByType($uri[5]);
                                }else{
                                    $this->getServiceType($uri[4]);
                                }
                            }else{
                                $this->getAllServiceTypes();
                            }
                        }else{
                            $this->getService($uri[3]);
                        }
                    } else {
                        $this->getAllServices();
                    }
                    break;
                case 'POST':
                    if (isset($uri[3])) {
                        $this->createService($uri[3]);
                    }
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

    private function createService($id_type)
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        error_log(print_r($data, true));

        try {
            $service = new ServiceModel($id_type,$data);

            $this->serviceService->createService($service);

            ResponseHelper::sendResponse(["Service ajouté avec succès." => $service]);
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
            ResponseHelper::sendResponse(["Service mis à jour avec succès." => $service]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    private function deleteService($id)
    {
        try {
            $service = $this->serviceService->getServiceById($id);
            if ($service) {
                ResponseHelper::sendResponse(['Service :' => $service]);
            } else {
                ResponseHelper::sendNotFound('Le service n existe pas.');
                return;
            }
            $result = $this->serviceService->deleteService($id);
            if ($result) {
                ResponseHelper::sendResponse(['success' => 'Service supprimé avec succès.']);
            } else {
                ResponseHelper::sendNotFound('Service non trouvé.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function getService($id)
    {
        try {
            $result = $this->serviceService->getServiceById($id);
            if ($result) {
                ResponseHelper::sendResponse(['success' => $result]);
            } else {
                ResponseHelper::sendNotFound('Service non trouvé.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * @throws Exception
     */
    private function getAllServices()
    {
        try {
            $result = $this->serviceService->getAllServices();
            if ($result) {
                ResponseHelper::sendResponse(['success' => $result]);
            } else {
                ResponseHelper::sendNotFound('Aucun service enregistré.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * @throws Exception
     */
    private function getAllServiceTypes(){
        try{
            $result = $this->serviceService->getAllServiceTypes();
            if ($result) {
                ResponseHelper::sendResponse(['success' => $result]);
            } else {
                ResponseHelper::sendNotFound('Aucun type de service enregistré.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function getServiceType($id_type)
    {
        try {
            $result = $this->serviceService->getServiceTypeById($id_type);
            if ($result) {
                ResponseHelper::sendResponse(['success' => $result]);
            } else {
                ResponseHelper::sendNotFound('Service non trouvé.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function getServicesByType($id_type)
    {
        try{
            $serviceType = $this->serviceService->getServiceTypeById($id_type);
            if ($serviceType) {
                $result = $this->serviceService->getServicesByType($id_type);
                ResponseHelper::sendResponse(['success' => $result]);
            } else {
                ResponseHelper::sendNotFound('Aucun type de service enregistré.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

}
?>