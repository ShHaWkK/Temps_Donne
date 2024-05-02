<?php

require_once './Repository/EntrepotRepository.php';
require_once './Models/EntrepotModel.php';

class EntrepotService {
    private $entrepotRepository;

    public function __construct(EntrepotRepository $entrepotRepository) {
        $this->entrepotRepository = $entrepotRepository;
    }

    public function getAllEntrepots() {
        return $this->entrepotRepository->findAll();
    }

    public function getEntrepotById($id) {
        return $this->entrepotRepository->findById($id);
    }

    public function createEntrepot($entrepotData) {
        $entrepot = new EntrepotModel($entrepotData);
        return $this->entrepotRepository->save($entrepot);
    }
    

    public function updateEntrepot($id, $newData) {
        $entrepot = $this->entrepotRepository->findById($id);
        if (!$entrepot) {
            throw new Exception("Entrepot not found");
        }

        // Mettre à jour les propriétés du modèle Entrepot
        foreach ($newData as $key => $value) {
            if (property_exists($entrepot, $key)) {
                $entrepot->$key = $value;
            }
        }

        return $this->entrepotRepository->update($entrepot);
    }

    public function deleteEntrepot($id) {
        $entrepot = $this->entrepotRepository->findById($id);
        if (!$entrepot) {
            throw new Exception("Entrepot not found");
        }

        return $this->entrepotRepository->delete($id);
    }
}

?>
