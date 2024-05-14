<?php

require_once './Repository/DemandeRepository.php';
require_once './Repository/UserRepository.php';
require_once './Repository/PlanningRepository.php';
//require_once './Helpers/NotificationHelper.php';


class DemandeService {
    private $demandeRepository;
    private $benevoleRepository;
    private $planningRepository;
    private $db;

    public function __construct() {
        $this->db=connectDB();
        $this->demandeRepository = new DemandeRepository();
        $this->benevoleRepository = new UserRepository($this->db);
        $this->planningRepository = new PlanningRepository($this->db);
    }

    public function getDemandeById($id) {
        return $this->demandeRepository->findById($id);
    }

    public function getAllDemandes() {
        return $this->demandeRepository->findAll();
    }

    public function saveDemande($demande) {
        $id = $this->demandeRepository->save($demande);
        return $id;
    }

    public function deleteDemande($id) {
        $this->demandeRepository->delete($id);
    }

    public function affecterBenevole($data) {
        $id_demande = $data['id_demande'];
        $id_benevole = $data['id_benevole'];
        $horaire = $data['horaire'];
        $lieu = $data['lieu'];

        $this->demandeRepository->assignBenevoleToDemande($id_demande, $id_benevole);
        $this->planningRepository->addActivityToPlanning($id_benevole, [
            'Date' => date('Y-m-d'),
            'Description' => "Affectation pour la demande $id_demande",
            'activity' => 'Service',
            'startTime' => $horaire,
            'endTime' => $horaire
        ]);
    }

    public function accepterDemande($UserId, $ServiceId)
    {
        $this->demandeRepository->accepterDemande($UserId, $ServiceId);
    }

    public function addDemande($UserId, $ServiceId)
    {
       return $this->demandeRepository->addDemande($UserId, $ServiceId);
    }

    public function getAllPendingDemands()
    {
        try {
            return $this->demandeRepository->getAllDemandsByStatus('En attente');
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des demandes : " . $e->getMessage());
        }

    }

    public function getAllGrantedDemands()
    {
        return $this->demandeRepository->getAllDemandsByStatus('Acceptee');
    }

    public function getAllRejectedDemands()
    {
        return $this->demandeRepository->getAllDemandsByStatus('Refusee');
    }
}
