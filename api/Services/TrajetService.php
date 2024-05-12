<?php
require_once 'Repository/TrajetRepository.php';
require_once 'Models/TrajetModel.php';

class TrajetService {
    private $trajetRepository;

    public function __construct($trajetRepository) {
        $this->trajetRepository = $trajetRepository;
    }

    public function createOrUpdateTrajet($data) {
        $trajet = new TrajetModel($data);
        if (isset($data['id'])) {
            return $this->trajetRepository->update($trajet);
        } else {
            return $this->trajetRepository->save($trajet);
        }
    }

    public function getAllTrajets() {
        return $this->trajetRepository->findAll();
    }

    public function getTrajetById($id) {
        return $this->trajetRepository->findById($id);
    }

    public function deleteTrajet($id) {
        return $this->trajetRepository->delete($id);
    }
}
?>
