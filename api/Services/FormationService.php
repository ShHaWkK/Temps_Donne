<?php
require_once './Repository/FormationRepository.php';

class FormationService {
    private $repository;

    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }

    public function getFormationsForVolunteer($userId) {
        return $this->repository->getFormationsForVolunteer($userId);
    }

    public function listAllFormations() {
        return $this->repository->getAllFormations();
    }

    public function getFormationDetails($id) {
        return $this->repository->getFormationById($id);
    }

    public function addFormation($data) {
        return $this->repository->addFormation($data);
    }

    public function updateFormation($id, $data) {
        return $this->repository->updateFormation($id, $data);
    }

    public function deleteFormation($id) {
        return $this->repository->deleteFormation($id);
    }

    public function registerVolunteerForFormation($userId, $formationId) {
        //A améliorer pour plus tard
        /*
        $formation = $this->repository->getFormationById($formationId);

        if (!$formation) {
            throw new Exception("Formation introuvable.");
        }

        $roomCapacity = $this->repository->getRoomCapacity($formation->lieu);
        $currentParticipants = $this->repository->getNumberOfParticipantsInFormation($formationId);

        if ($currentParticipants >= $roomCapacity) {
            throw new Exception("La salle ne peut pas accueillir plus de participants.");
        }
         */
        return $this->repository->registerVolunteerForFormation($userId, $formationId);
    }

    public function unregisterVolunteerFromFormation($userId, $formationId) {
        return $this->repository->unregisterVolunteerFromFormation($userId, $formationId);
    }

    public function getRegistrationsForFormation($formationId) {
        return $this->repository->getRegistrationsForFormation($formationId);
    }

    public function generateReports() {
        return $this->repository->getParticipationAndFeedback();
    }

    public function addFeedback($data) {
        return $this->repository->insertFeedback($data);
    }

    public function getAvailableFormations() {
        return $this->repository->getAvailableFormations();
    }

    public function getAllSessionsForUser($userId) {
        return $this->repository->getAllSessionsForUser($userId);
    }

    public function getUpcomingSessionsForFormation($formationId) {
        return $this->repository->getUpcomingSessionsForFormation($formationId);
    }

    public function getAllFormationSessions($formationId)
    {
        return $this->repository->getAllFormationSessions($formationId);
    }

    public function getAllInscriptions()
    {
        return $this->repository->getAllInscriptions();
    }

    /**
     * @throws Exception
     */
    public function validateAttendance($userId, $formationId) {
        return $this->repository->markAttendance($userId, $formationId,'confirmee');
    }

    /**
     * @throws Exception
     */
    public function rejectAttendance($userId, $formationId)
    {
        return $this->repository->markAttendance($userId, $formationId,'refusee');

    }

    /**
     * @throws Exception
     */
    public function putOnHoldAttendance($userId, $formationId)
    {
        return $this->repository->markAttendance($userId, $formationId,'en_attente');
    }

    public function getSessionRoom($roomId)
    {
        return $this->repository->getSessionRoom($roomId);
    }

    public function getAllRooms()
    {
        return $this->repository->getAllRooms();
    }

    public function addSession($data)
    {
        return $this->repository->addSession($data);
    }

}
