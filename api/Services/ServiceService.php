<?php
//Oui, le nom de cette classe est ce qu'il est, mais pas trop le choix
require_once './Repository/ServiceRepository.php';
require_once './Models/ServiceModel.php';
require_once './Helpers/ResponseHelper.php';
class ServiceService{
    private $serivceRepository;

    public function __construct(ServiceRepository $serviceRepository) {
        $this->serviceRepository = $serviceRepository;
    }

    public function createService(ServiceModel $service)
    {
        $serviceId = $this->serviceRepository->save($service);
    }

    public function getServiceById($id) {
        try {
            var_dump($this->serviceRepository->getServiceById($id));

            return $this->serviceRepository->getServiceById($id);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du service : " . $e->getMessage());
        }
    }

    public function updateService($service,$fieldsToUpdate)
    {
        return $this->serviceRepository->updateService($service,$fieldsToUpdate);
    }
}
?>