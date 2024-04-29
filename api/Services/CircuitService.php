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

    private function loadGraphData() {
        $db = $this->circuitRepository->getDbConnection();
        
        $nodesSql = "SELECT id, name FROM nodes";
        $edgesSql = "SELECT start_point, end_point, cost FROM edges";

        try {
            $stmt = $db->query($nodesSql);
            $nodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $db->query($edgesSql);
            $edges = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $graph = [];
            foreach ($nodes as $node) {
                $graph[$node['id']] = [];
            }
            foreach ($edges as $edge) {
                $graph[$edge['start_point']][$edge['end_point']] = $edge['cost'];
            }

            return $graph;
        } catch (PDOException $e) {
            exit_with_message("Error loading graph data: " . $e->getMessage());
        }
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

    public function planRoute($startPoint, $endPoint) {
        return $this->aStarService->findShortestPath($startPoint, $endPoint);
    }
}

?>
