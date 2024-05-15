<?php
// file : api/Repository/PlanningRepository.php

require_once './Models/PlanningModel.php';

class PlanningRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //On récupère la date et l'heure du planning dans la table Services
    public function getServiceInfo($serviceId) {
        $stmt = $this->db->prepare("SELECT Date, startTime, endTime FROM Services WHERE ID_Service = ?");
        $stmt->execute([$serviceId]);
        return $stmt->fetch();
    }

    //On vérifie qu'il n'y a pas de conflit sur les dates
    public function checkScheduleConflict($userID, $date, $startTime, $endTime) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Planning AS p
                                INNER JOIN Services AS s ON p.ID_Service = s.ID_Service
                                WHERE p.ID_Utilisateur = ? 
                                AND s.Date = ?
                                AND (
                                    (s.startTime BETWEEN ? AND ?) OR
                                    (s.endTime BETWEEN ? AND ?) OR
                                    (s.startTime < ? AND s.endTime > ?)
                                )");
        $stmt->execute([
            $userID,
            $date,
            $startTime,
            $endTime,
            $startTime,
            $endTime,
            $startTime,
            $endTime
        ]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function save(PlanningModel $planning) {
        // Récupérer les informations sur le service associé au planning
        $serviceInfo = $this->getServiceInfo($planning->ID_Service);

        // Vérifier s'il y a un conflit d'horaire pour cet utilisateur
        if ($this->checkScheduleConflict($planning->ID_Utilisateur, $serviceInfo['Date'], $serviceInfo['startTime'], $serviceInfo['endTime'])) {
            throw new Exception("Un planning existe déjà pour cet utilisateur à cette date et heure.");
        }

        // Insertion du nouveau planning si aucun conflit n'est détecté
        $stmtInsert = $this->db->prepare("INSERT INTO Planning (ID_Utilisateur, ID_Service, description) VALUES (?, ?, ?)");
        $stmtInsert->execute([
            $planning->ID_Utilisateur,
            $planning->ID_Service,
            $planning->description
        ]);
        return $this->db->lastInsertId();
    }

    private function isPlanningAvailable($userId, $date, $startTime, $endTime) {
        // Requête pour vérifier si un planning avec les mêmes informations existe déjà
        $stmt = $this->db->prepare("SELECT * FROM Planning WHERE ID_Utilisateur = ? AND Date = ? AND ((startTime < ? AND endTime > ?) OR (startTime < ? AND endTime > ?) OR (startTime >= ? AND endTime <= ?))");
        $stmt->execute([$userId, $date, $startTime, $startTime, $endTime, $endTime, $startTime, $endTime]);
        $planning = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Si un planning existe déjà, il y a un conflit
        return !$planning;
    }

    public function update(PlanningModel $planning) {
        $stmt = $this->db->prepare("UPDATE Planning SET ID_Utilisateur = ?, activity = ?, description = ?, date = ?, startTime = ?, endTime = ? WHERE ID_Planning = ?");
        $stmt->execute([
            $planning->ID_Utilisateur, 
            $planning->activity,
            $planning->description, 
            $planning->date,
            $planning->startTime,
            $planning->endTime,
            $planning->ID_Planning 
        ]);
    }
    
    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM Planning");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Planning WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function remove($id) { 
        $stmt = $this->db->prepare ('DELETE FROM Planning WHERE ID_Planning =?');
        $stmt->bindValue (1 , $id, PDO::PARAM_INT);
        $res = $stmt->execute([$id]);    
        if(!$res){
            throw new Exception('Impossible de supprimer  la planning');
        }
    }

    private function isVolunteerAvailable($userId, $dateTime) {
        // Requête pour vérifier s'il existe des Planning qui se chevauchent pour ce bénévole à cette date et heure
        $stmt = $this->db->prepare("SELECT * FROM Planning WHERE ID_Utilisateur = :userId AND Date = :date");
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':date', $dateTime);
        $stmt->execute();
        $planning = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Si un planning existe déjà, le bénévole n'est pas disponible
        return !$planning;
    }
    
    private function hasVolunteerRequiredSkills($userId, $serviceId) {
        // Requête pour obtenir les compétences requises pour le service
        $stmt = $this->db->prepare("SELECT c.Nom_Competence FROM Competences c INNER JOIN ServicesCompetences sc ON c.ID_Competence = sc.ID_Competence WHERE sc.ID_Service = :serviceId");
        $stmt->bindValue(':serviceId', $serviceId);
        $stmt->execute();
        $requiredSkills = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        // Requête pour obtenir les compétences du bénévole
        $stmt = $this->db->prepare("SELECT c.Nom_Competence FROM Competences c INNER JOIN UtilisateursCompetences uc ON c.ID_Competence = uc.ID_Competence WHERE uc.ID_Utilisateur = :userId");
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        $volunteerSkills = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        // Vérifiez si toutes les compétences requises sont dans les compétences du bénévole
        return !array_diff($requiredSkills, $volunteerSkills);
    }

    public function assignToService($userId, $serviceId, $dateTime) {
        if (!$this->isVolunteerAvailable($userId, $dateTime) || !$this->hasVolunteerRequiredSkills($userId, $serviceId)) {
            throw new Exception("Le bénévole n'est pas disponible ou n'a pas les compétences requises.");
        }
    
        $stmt = $this->db->prepare("INSERT INTO Planning (ID_Utilisateur, ID_Service, Date) VALUES (:userId, :serviceId, :dateTime)");
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':serviceId', $serviceId);
        $stmt->bindValue(':dateTime', $dateTime);
        $stmt->execute();
    }

    public function removeVolunteerFromService($userId, $serviceId, $dateTime) {
        $stmt = $this->db->prepare("DELETE FROM Planning WHERE ID_Utilisateur = :userId AND ID_Service = :serviceId AND Date = :dateTime");
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':serviceId', $serviceId);
        $stmt->bindValue(':dateTime', $dateTime);
        $stmt->execute();
    }
    
    public function getPlanningByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM Planning WHERE ID_Utilisateur = :userId");
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addActivityToPlanning($id_utilisateur, $activity) {
        $sql = "INSERT INTO Planning (ID_Utilisateur, Date, Description, activity, startTime, endTime) VALUES (:id_utilisateur, :date, :description, :activity, :startTime, :endTime)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->bindValue(':date', $activity['Date']);
        $stmt->bindValue(':description', $activity['Description'], PDO::PARAM_STR);
        $stmt->bindValue(':activity', $activity['activity'], PDO::PARAM_STR);
        $stmt->bindValue(':startTime', $activity['startTime']);
        $stmt->bindValue(':endTime', $activity['endTime']);
        $stmt->execute();
    }


}
