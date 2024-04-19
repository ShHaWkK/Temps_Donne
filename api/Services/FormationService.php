<?php
require_once './Repository/FormationRepository.php';

class FormationService {
    private $repository;

    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }

    public function listAllFormations() {
        return $this->repository->getAllFormations();
    }

    public function getFormationDetails($id) {
        return $this->repository->getFormationById($id);
    }

    public function addFormation($data) {
        return $this->repository->addFormation($data);
    }

    public function updateFormation($id, $data) {
        return $this->repository->updateFormation($id, $data);
    }

    public function deleteFormation($id) {
        return $this->repository->deleteFormation($id);
    }
}
