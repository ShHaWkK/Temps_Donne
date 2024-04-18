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

}

?>