<?php
require_once './Repository/CircuitRepository.php';
require_once './Models/CircuitModel.php';

class CircuitService {
    private $circuitRepository;

    public function __construct(CircuitRepository $circuitRepository) {
        $this->circuitRepository = $circuitRepository;
    }

    public function getAllCircuits() {
        return $this->circuitRepository->findAll();
    }

    public function getCircuitById($id) {
        return $this->circuitRepository->findById($id);
    }

    public function createCircuit($circuitData) {
        $circuit = new CircuitModel($circuitData);
        return $this->circuitRepository->save($circuit);
    }

    public function updateCircuit($id, $newData) {
        $circuit = $this->circuitRepository->findById($id);
        if (!$circuit) {
            throw new Exception("Circuit not found");
        }

        // Mettre à jour les propriétés du modèle Circuit
        foreach ($newData as $key => $value) {
            if (property_exists($circuit, $key)) {
                $circuit->$key = $value;
            }
        }

        return $this->circuitRepository->update($circuit);
    }

    public function deleteCircuit($id) {
        $circuit = $this->circuitRepository->findById($id);
        if (!$circuit) {
            throw new Exception("Circuit not found");
        }

        return $this->circuitRepository->delete($id);
    }

    public function findAll() {
        return $this->circuitRepository->findAll();
    }

    public function findByDate($date) {
        return $this->circuitRepository->findByDate($date);
    }

    public function findByChauffeur($chauffeurId) {
        return $this->circuitRepository->findByChauffeur($chauffeurId);
    }
}

?>
