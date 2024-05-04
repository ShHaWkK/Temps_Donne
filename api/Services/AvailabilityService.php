<?php
require_once './Repository/AvailabilityRepository.php';
require_once './Models/AvailabilityModel.php';

class AvailabilityService {
    private $availabilityRepository;

    public function __construct(AvailabilityRepository $availabilityRepository) {
        $this->availabilityRepository = $availabilityRepository;
    }

    public function createAvailability(AvailabilityModel $availability) {
        try {
            $availabilityId = $this->availabilityRepository->createAvailability($availability);
            return $availabilityId;
        } catch (Exception $e) {
            throw new Exception("Error while creating availability: " . $e->getMessage());
        }
    }

    public function getAvailabilityById($id) {
        try {
            return $this->availabilityRepository->getAvailabilityById($id);
        } catch (Exception $e) {
            throw new Exception("Error while retrieving availability: " . $e->getMessage());
        }
    }
}
?>