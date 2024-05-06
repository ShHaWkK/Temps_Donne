<?php
require_once './Services/AvailabilityService.php'; // Assurez-vous que le chemin est correct

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class AvailabilityController
{
    private $availabilityService;

    public function __construct()
    {
        $db = connectDB();
        $availabilityRepository = new AvailabilityRepository($db);
        $this->availabilityService = new AvailabilityService($availabilityRepository);
    }

    public function processRequest($method, $uri)
    {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getUserAvailabilities($uri[3]);
                    }
                    break;
                default:
                    throw new Exception("URI invalide.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    private function getUserAvailabilities($id)
    {
        try
        {
            $availabilities = $this->availabilityService->getAvailabilityByUserId($id);
            if (!$availabilities) {
                ResponseHelper::sendNotFound("Availabilities not found.");
            } else {
                ResponseHelper::sendResponse($availabilities);
            }
        }
        catch(Exception $e)
        {
            throw new Exception("Erreur lors de la récupération des disponibilités : " . $e->getMessage());
        }
    }

}
