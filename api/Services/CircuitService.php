<?php
require_once './Repository/CircuitRepository.php';
require_once './Models/CircuitModel.php';
require_once 'AStarService.php';

class CircuitService {
    private $circuitRepository;
    private $aStarService;

    public function __construct(CircuitRepository $circuitRepository) {
        $this->circuitRepository = $circuitRepository;
        $graph = $this->loadGraphData();
        $this->aStarService = new AStarService($graph);
    }

    public function getAllCircuits() {
        return $this->circuitRepository->findAll();
    }

    public function getCircuitById($id) {
        return $this->circuitRepository->findById($id);
    }

    public function createCircuit($circuitData) {
        $circuit = new CircuitModel($circuitData);
        $circuit->validate();

        $circuitId = $this->circuitRepository->save($circuit);
        $circuit->id = $circuitId;

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
            throw new Exception("Circuit not found");
        }

        return $this->circuitRepository->delete($id);
    }

    public function findAll() {
        return $this->circuitRepository->findAll();
    }

    private function generateQrCode(CircuitModel $circuit) {
        $circuit->generateQrCode();
        $this->circuitRepository->updateQrCodePath($circuit->id, $circuit->qr_code);
    }

    public function findByDate($date) {
        return $this->circuitRepository->findByDate($date);
    }

    public function findByChauffeur($chauffeurId) {
        return $this->circuitRepository->findByChauffeur($chauffeurId);
    }


    public function planRoute($startPoint, $endPoint) {
        return $this->aStarService->findShortestPath($startPoint, $endPoint);
    }

}

?>