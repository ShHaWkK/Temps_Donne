<?php
//Oui, le nom de cette classe est ce qu'il est, mais pas trop le choix
require_once './Repository/ServiceRepository.php';
require_once './Models/ServiceModel.php';
require_once './Helpers/ResponseHelper.php';
class ServiceService{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository) {
        $this->serviceRepository = $serviceRepository;
    }

    public function createService(ServiceModel $service)
    {
        $serviceId = $this->serviceRepository->createService($service);
    }

    public function getServiceById($id) {
        try {
            return $this->serviceRepository->getServiceById($id);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du service : " . $e->getMessage());
        }
    }

    public function getServiceTypeById($id) {
        try {
            return $this->serviceRepository->getServiceTypeById($id);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du type de service : " . $e->getMessage());
        }
    }

    public function updateService($service,$fieldsToUpdate)
    {
        return $this->serviceRepository->updateService($service,$fieldsToUpdate);
    }

    public function deleteService($id)
    {
        return $this->serviceRepository->deleteService($id);
    }

    public function getAllServices()
    {
        try {
            return $this->serviceRepository->getAllServices();

        }catch (\mysql_xdevapi\Exception$e){
            throw new Exception("Erreur lors de la récupération des services : " . $e->getMessage());
        }
    }

    public function getAllServiceTypes()
    {
        try {
            return $this->serviceRepository->getAllServiceTypes();
        }catch (\mysql_xdevapi\Exception$e){
            throw new Exception("Erreur lors de la récupération du type service : " . $e->getMessage());
        }
    }

    public function getServicesByType($id_type)
    {
        try {
            return $this->serviceRepository->getServicesByType($id_type);
        }catch (\mysql_xdevapi\Exception$e){
            throw new Exception("Erreur lors de la récupération du type service : " . $e->getMessage());
        }
    }
}
?>