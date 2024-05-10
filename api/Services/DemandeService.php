<?php

require_once './Repository/DemandeRepository.php';
require_once './Repository/BenevoleRepository.php';
require_once './Repository/PlanningRepository.php';
require_once './Helpers/NotificationHelper.php';

class DemandeService {
    private $demandeRepository;
    private $benevoleRepository;
    private $planningRepository;

    public function __construct(DemandeRepository $demandeRepository, BenevoleRepository $benevoleRepository, PlanningRepository $planningRepository) {
        $this->demandeRepository = $demandeRepository;
        $this->benevoleRepository = $benevoleRepository;
        $this->planningRepository = $planningRepository;
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
}
