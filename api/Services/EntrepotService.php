<?php
require_once 'Repository/EntrepotRepository.php';
require_once 'Models/EntrepotModel.php';

class EntrepotService {
    private $entrepotRepository;

    public function __construct(EntrepotRepository $entrepotRepository) {
        $this->entrepotRepository = $entrepotRepository;
    }

    public function createEntrepot(EntrepotModel $entrepot) {
        return $this->entrepotRepository->save($entrepot);
    }

    public function getAllEntrepots() {
        return $this->entrepotRepository->findAll();
    }

    public function getEntrepotById($id) {
        return $this->entrepotRepository->findById($id);
    }

    public function updateEntrepot($data) {
        $entrepot = new EntrepotModel($data);
        $this->entrepotRepository->update($entrepot);
    }

    public function deleteEntrepot($id) {
        $this->entrepotRepository->delete($id);
    }
}

?>
