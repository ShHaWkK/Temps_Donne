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
        if (is_array($circuitData)) {
            $circuit = new CircuitModel($circuitData);
        } else {
            throw new Exception("Invalid data format", 400);
        }

        $circuit->validate();

        $circuitId = $this->circuitRepository->save($circuit);
        $circuit->id_circuit = $circuitId;

        $this->generateQrCode($circuit);
        return $circuitId;
    }

    public function updateCircuit($id, $newData) {
        $circuit = $this->circuitRepository->findById($id);
        if (!$circuit) {
            throw new Exception("Circuit not found", 404);
        }

        // Mettre à jour les propriétés du modèle Circuit
        foreach ($newData as $key => $value) {
            if (property_exists($circuit, $key)) {
                $circuit->$key = $value;
            }
        }

        $circuit->validate();
        $this->circuitRepository->update($circuit);
        $this->generateQrCode($circuit);
    }

    public function deleteCircuit($id) {
        $circuit = $this->circuitRepository->findById($id);
        if (!$circuit) {
            throw new Exception("Circuit not found", 404);
        }

        return $this->circuitRepository->delete($id);
    }

    private function generateQrCode(CircuitModel $circuit) {
        $circuit->generateQrCode();
        $this->circuitRepository->updateQrCodePath($circuit->id_circuit, $circuit->qr_code);
    }

    public function findByDate($date) {
        return $this->circuitRepository->findByDate($date);
    }

    public function findByChauffeur($chauffeurId) {
        return $this->circuitRepository->findByChauffeur($chauffeurId);
    }
}
