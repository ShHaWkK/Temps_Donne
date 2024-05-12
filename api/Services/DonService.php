
<?php

class DonService {
    private $donRepository;

    public function __construct($donRepository) {
        $this->donRepository = $donRepository;
    }

    public function getDons() {
        return $this->donRepository->getDons();
    }

    public function getDonById($id) {
        return $this->donRepository->getDonById($id);
    }

    public function createDon($don) {
        // Validation ou traitement de la logique métier avant insertion
        if ($don->montant <= 0) {
            throw new Exception("Le montant du don ne peut pas être négatif ou nul.", 400);
        }
        return $this->donRepository->createDon($don);
    }

    public function updateDon($don) {
        // Validation ou traitement de la logique métier avant mise à jour
        if ($don->montant <= 0) {
            throw new Exception("Le montant du don ne peut pas être négatif ou nul.", 400);
        }
        return $this->donRepository->updateDon($don);
    }

    public function deleteDon($id) {
        // Vérification avant suppression, si nécessaire
        $existingDon = $this->getDonById($id);
        if (!$existingDon) {
            throw new Exception("Le don avec l'ID $id n'existe pas.", 404);
        }
        return $this->donRepository->deleteDon($id);
    }
}
?>