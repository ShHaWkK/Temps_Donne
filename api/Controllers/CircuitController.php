<?php

require_once './Services/CircuitService.php';
require_once './Models/CircuitModel.php';
require_once './Helpers/ResponseHelper.php';
//require_once './pdf_generator/pdf_template.php';

class CircuitController {
    private $circuitService;
    private $circuitPdf;

    public function __construct() {
        $this->circuitService = new CircuitService(new CircuitRepository());
//        $this->circuitPdf = new CircuitPdf();
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        switch ($uri[2]) {
                            case 'date':
                                $this->findByDate($uri[3]);
                                break;
                            case 'chauffeur':
                                $this->findByChauffeur($uri[3]);
                                break;
                            default:
                                $this->getCircuit($uri[3]);
                                break;
                        }
                    } else {
                        $this->getAllCircuits();
                    }
                    break;
                case 'POST':
                    if (isset ($uri[3])){
                        if($uri[3] == 'pdf')
                        $this->saveUploadedFile();
                    }else{
                        $this->createCircuit();
                    }
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateCircuit($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteCircuit($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendNotFound("Méthode HTTP non supportée.");
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function getCircuit($id) {
        $circuit = $this->circuitService->getCircuitById($id);
        if (!$circuit) {
            ResponseHelper::sendNotFound("Circuit introuvable.");
        } else {
            ResponseHelper::sendResponse($circuit);
        }
    }

    private function getAllCircuits() {
        $circuits = $this->circuitService->getAllCircuits();
        ResponseHelper::sendResponse($circuits);
    }

    private function createCircuit() {
        $data = json_decode(file_get_contents('php://input'), true);
        $circuitId = $this->circuitService->createCircuit($data);
        ResponseHelper::sendResponse(['message' => 'Circuit créé avec succès', 'id' => $circuitId], 201);
    }

    private function updateCircuit($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->circuitService->updateCircuit($id, $data);
        ResponseHelper::sendResponse(['message' => 'Circuit mis à jour avec succès']);
    }

    private function deleteCircuit($id) {
        $this->circuitService->deleteCircuit($id);
        ResponseHelper::sendResponse(['message' => 'Circuit supprimé avec succès']);
    }

    private function findByDate($date) {
        $circuits = $this->circuitService->findByDate($date);
        if (!empty($circuits)) {
            ResponseHelper::sendResponse($circuits);
        } else {
            ResponseHelper::sendNotFound("Aucun circuit trouvé pour la date spécifiée.");
        }
    }

    private function findByChauffeur($chauffeurId) {
        $circuits = $this->circuitService->findByChauffeur($chauffeurId);
        if (!empty($circuits)) {
            ResponseHelper::sendResponse($circuits);
        } else {
            ResponseHelper::sendNotFound("Aucun circuit trouvé pour le chauffeur spécifié.");
        }
    }

    public function saveUploadedFile()
    {
        if (!($_FILES['circuit_pdf'])) {
            throw new Exception("Aucun fichier n'a été téléchargé.");
        }

        $target_dir_file = "./uploads/"  . "Circuits/";

        if (!file_exists($target_dir_file)) {
            mkdir($target_dir_file, 0777, true);
        }

        $file_path = $target_dir_file . "Circuit_". date("Y-m-d_H-i-s") . ".pdf";

        var_dump($file_path);

        $file = $_FILES['circuit_pdf'];
        $file_moved = move_uploaded_file($file['tmp_name'], $file_path);

        var_dump($file_moved);

        if (!$file_moved) {
            throw new Exception("Une erreur s'est produite lors de l'enregistrement du permis.");
        }

        return [
            'status' => "success",
            'message' => "Le justificatif du permis a bien été enregistré.",
        ];
    }
}