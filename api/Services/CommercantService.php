<?php

require_once 'Repository/CommercantRepository.php';

class CommercantService {
    private $repository;

    public function __construct(CommercantRepository $repository) {
        $this->repository = $repository;
    }

    public function getAllCommercants() {
        return $this->repository->findAll();
    }

    public function getCommercantById($id) {
        return $this->repository->findById($id);
    }

    public function createOrUpdateCommercant($data) {
        $commercant = new Commercant($data);
        return $this->repository->save($commercant);
    }

    public function deleteCommercant($id) {
        $this->repository->delete($id);
    }
}
?>