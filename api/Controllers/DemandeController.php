<?php

require_once './Services/DemandeService.php';
require_once './Helpers/ResponseHelper.php';

class DemandeController {
    private $demandeService;

    public function __construct() {
        $this->demandeService = new DemandeService(new DemandeRepository(), new BenevoleRepository(), new PlanningRepository(), new NotificationRepository());
    }

    public function processRequest($method, $uri) {
        switch ($method) {
            case 'GET':
                if (isset($uri[3])) {
                    $this->getDemande($uri[3]);
                } else {
                    $this->getAllDemandes();
                }
                break;
            case 'POST':
                if (isset($uri[3]) && $uri[3] === 'affecter') {
                    $this->affecterBenevole();
                } elseif (isset($uri[3]) && $uri[3] === 'accepter') {
                    $this->accepterDemande();
                } else {
                    $this->createDemande();
                }
                break;
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
}
