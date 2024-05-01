<?php

require_once './Repository/PlanningRepository.php';
require_once './Repository/UserRepository.php';
require_once './Models/PlanningModel.php';
require_once './Models/UserModel.php';

class PlanningService {
    private $planningRepository;
    private $userRepository;

    public function __construct(PlanningRepository $planningRepository, UserRepository $userRepository) {
        $this->planningRepository = $planningRepository;
        $this->userRepository = $userRepository;
    }

    public function addPlanning(PlanningModel $planning) {
        return $this->planningRepository->save($planning);
    }

    public function createPlanning($data) {
        $planning = new PlanningModel($data);
        return $this->planningRepository->save($planning);
    }

    public function updatePlanning($planningId, $newDetails) {
        // Récupérer le planning existant
        $existingPlanning = $this->planningRepository->getById($planningId);

        if (!$existingPlanning) {
            throw new Exception("Planning not found");
        }

        // Mettre à jour le planning existant avec les nouveaux détails
        foreach ($newDetails as $key => $value) {
            if (property_exists($existingPlanning, $key)) {
                $existingPlanning->$key = $value;
            }
        }

        // Mettre à jour le planning dans la base de données
        $this->planningRepository->update($existingPlanning);
    }

    public function deletePlanning($planningId) {
        $this->planningRepository->remove($planningId);
    }

    public function getPlanning($planningId) {
        return $this->planningRepository->getById($planningId);
    }

    public function getUserPlanning($user_id)
    {
        return $this->planningRepository->getPlanningByUserId($user_id);
    }

    public function getAllPlannings() {
        return $this->planningRepository->findAll();
    }



    public function getPlanningsForVolunteer($userId) {
        if (!$this->userRepository->isUserVolunteer($userId)) {
            throw new Exception("L'utilisateur n'est pas un bénévole.");
        }
        return $this->planningRepository->getPlanningsByUserId($userId);
    }

    public function assignVolunteerToService($userId, $serviceId, $dateTime) {
        if (!$this->isVolunteerAvailable($userId, $dateTime) || !$this->hasVolunteerRequiredSkills($userId, $serviceId)) {
            throw new Exception("Le bénévole n'est pas disponible ou n'a pas les compétences requises.");
        }
        $this->planningRepository->assignToService($userId, $serviceId, $dateTime);
    }

    private function isVolunteerAvailable($userId, $dateTime) {
        $plannings = $this->planningRepository->getPlanningsByUserId($userId);
        foreach ($plannings as $planning) {
            // Convertir les dates en format standard pour comparaison
            $planningDate = new DateTime($planning['date']);
            $requestedDate = new DateTime($dateTime);
    
            if ($planningDate == $requestedDate) {
                // Le bénévole a déjà un planning à cette date
                return false;
            }
        }
        return true;
    }

    private function hasVolunteerRequiredSkills($userId, $serviceId) {
        // Récupérer les compétences requises pour le service
        $requiredSkills = $this->serviceRepository->getRequiredSkillsForService($serviceId);
    
        // Récupérer les compétences du bénévole
        $volunteerSkills = $this->userRepository->getSkillsByUserId($userId);
    
        // Vérifier si toutes les compétences requises sont présentes chez le bénévole
        foreach ($requiredSkills as $skill) {
            if (!in_array($skill, $volunteerSkills)) {
                return false; // Le bénévole n'a pas toutes les compétences requises
            }
        }
        return true; // Le bénévole a toutes les compétences requises
    }
}
?>