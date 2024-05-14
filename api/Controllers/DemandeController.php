<?php

require_once './Services/DemandeService.php';
require_once './Helpers/ResponseHelper.php';

class DemandeController {

    private $demandeService;
    private $db;

    public function __construct() {
        $this->db = connectDB();
        $this->demandeService = new DemandeService();
    }

    public function processRequest($method, $uri)
    {
        switch ($method) {
            case 'POST':
                $this->addDemande($uri[3],$uri[4]);
                break;
            case 'GET':
                if (isset($uri[3])) {
                    $this->getDemande($uri[3]);
                } else {
                    $this->getAllDemandes();
                }
                break;
                /*
            case 'POST':
                if (isset($uri[3]) && $uri[3] === 'affecter') {
                    $this->affecterBenevole();
                } elseif (isset($uri[3]) && $uri[3] === 'accepter') {
                    $this->accepterDemande();
                } else {

//                }
//                $this->createDemande($uri[3],$uri[4]);
                break;
                */
            case 'PUT':
                if (isset($uri[3])) {
                    $this->updateDemande($uri[3]);
                }
                break;
            case 'DELETE':
                if (isset($uri[3])) {
                    $this->deleteDemande($uri[3]);
                }
                break;
            default:
                ResponseHelper::sendMethodNotAllowed("Méthode HTTP non supportée.");
                break;
        }
    }

    private function getDemande($id) {
        $demande = $this->demandeService->getDemandeById($id);
        if (!$demande) {
            ResponseHelper::sendNotFound("Demande introuvable.");
        } else {
            ResponseHelper::sendResponse($demande);
        }
    }

    private function getAllDemandes() {
        $demandes = $this->demandeService->getAllDemandes();
        ResponseHelper::sendResponse($demandes);
    }

    private function createDemande() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $this->demandeService->saveDemande($data);
        ResponseHelper::sendResponse(['message' => 'Demande créée avec succès', 'id' => $id], 201);
    }

    private function updateDemande($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->demandeService->saveDemande(array_merge(['id_demande' => $id], $data));
        ResponseHelper::sendResponse(['message' => 'Demande mise à jour avec succès']);
    }

    private function deleteDemande($id) {
        $this->demandeService->deleteDemande($id);
        ResponseHelper::sendResponse(['message' => 'Demande supprimée avec succès']);
    }

    private function affecterBenevole() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->demandeService->affecterBenevole($data);
        ResponseHelper::sendResponse(['message' => 'Bénévole affecté avec succès']);
    }

    private function accepterDemande() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->demandeService->accepterDemande($data);
        ResponseHelper::sendResponse(['message' => 'Demande acceptée avec succès']);
    }

    private function addDemande( $UserId, $ServiceId)
    {
        try {
            $result = $this->demandeService->addDemande($UserId, $ServiceId);
            if (!$result) {
                ResponseHelper::sendResponse("Failed to create Demand", 400);
            } else {
                ResponseHelper::sendResponse("Demand created successfully", 201);
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], 400);
        }
        /*
        $this->demandeService->addDemande($UserId, $ServiceId);
        ResponseHelper::sendResponse(['message' => 'Demande ajoutée avec succès']);*/
    }
}
