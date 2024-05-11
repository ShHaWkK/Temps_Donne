<?php
require_once './Models/FormationModel.php';

class FormationRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //-------------------- Formation Volunteering --------------------//

    public function getFormationsForVolunteer($userId) {
        $query = "SELECT f.*, i.Date_Inscription 
                  FROM Formations f
                  JOIN Inscriptions_Formations i ON f.ID_Formation = i.ID_Formation
                  WHERE i.ID_Utilisateur = :userId";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        $formations = [];
        while ($row = $statement->fetch()) {
            $formations[] = new FormationModel($row);
        }
        return $formations;
    }

    //-------------------- Formation CRUD --------------------//

    public function getAllFormations() {
        $query = "SELECT * FROM Formations";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $formations = [];
        while ($row = $statement->fetch()) {
            $formations[] = new FormationModel($row);
        }
        return $formations;
    }
    
    public function getFormationById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Formations WHERE ID_Formation = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? new FormationModel($data) : null;
    }

    public function addFormation($data) {
        $stmt = $this->db->prepare("INSERT INTO Formations (Titre, Description, Date_Formation, Duree, Lieu, ID_Organisateur) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['Titre'], $data['Description'], $data['Date_Formation'], $data['Duree'], $data['Lieu'], $data['ID_Organisateur']]);
    }

    public function updateFormation($id, $data) {
        $stmt = $this->db->prepare("UPDATE Formations SET Titre = ?, Description = ?, Date_Formation = ?, Duree = ?, Lieu = ? WHERE ID_Formation = ?");
        return $stmt->execute([$data['Titre'], $data['Description'], $data['Date_Formation'], $data['Duree'], $data['Lieu'], $id]);
    }

    public function deleteFormation($id) {
        $stmt = $this->db->prepare("DELETE FROM Formations WHERE ID_Formation = ?");
        return $stmt->execute([$id]);
    }

    //-------------------- Formation Volunteering --------------------//

    public function isUserRegisteredForFormation($userId, $formationId) {
        $query = "SELECT COUNT(*) FROM Inscriptions_Formations WHERE ID_Utilisateur = :user_id AND ID_Formation = :formation_id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':formation_id', $formationId);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    public function registerVolunteerForFormation($userId, $formationId) {
        if ($this->isUserRegisteredForFormation($userId, $formationId)) {
            return false; 
        }

        $query = "INSERT INTO Inscriptions_Formations (ID_Utilisateur, ID_Formation, Date_Inscription) VALUES (:user_id, :formation_id, CURDATE())";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':formation_id', $formationId);
        return $statement->execute();
    }

    public function unregisterVolunteerFromFormation($userId, $formationId) {
        if (!$this->isUserRegisteredForFormation($userId, $formationId)) {
            return false; 
        }

        $query = "DELETE FROM Inscriptions_Formations WHERE ID_Utilisateur = :user_id AND ID_Formation = :formation_id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':formation_id', $formationId);
        return $statement->execute();
    }

    public function getRegistrationsForFormation($formationId) {
        $stmt = $this->db->prepare("SELECT u.* 
                                    FROM Utilisateurs u
                                    JOIN Inscriptions_Formations i ON u.ID_Utilisateur = i.ID_Utilisateur
                                    WHERE i.ID_Formation = ?");
        $stmt->execute([$formationId]);
        return $stmt->fetchAll();
    }

    public function markAttendance($userId, $formationId) {
        $stmt = $this->db->prepare("UPDATE Inscriptions_Formations SET Attended = TRUE WHERE ID_Utilisateur = ? AND ID_Formation = ?");
        $stmt->execute([$userId, $formationId]);
        return $stmt->rowCount() > 0;
    }

    public function getParticipationAndFeedback() {
        $query = "SELECT f.ID_Formation, f.Titre, COUNT(i.ID_Utilisateur) AS Participants, COUNT(fb.ID_Feedback) AS FeedbackCount 
                  FROM Formations f 
                  JOIN Inscriptions_Formations i ON f.ID_Formation = i.ID_Formation 
                  LEFT JOIN Feedbacks fb ON f.ID_Formation = fb.ID_Reference AND fb.Type = 'Formation' 
                  GROUP BY f.ID_Formation";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    //-------------------- Formation Feedback --------------------//

    public function insertFeedback($data) {
        $stmt = $this->db->prepare("INSERT INTO Feedbacks (ID_Utilisateur, Type, ID_Reference, Commentaire, Date_Creation) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['userId'], 
            'Formation', 
            $data['formationId'], 
            $data['comment'], 
            date('Y-m-d') 
        ]);
    }

    public function getAvailableFormations() {
        $stmt = $this->db->prepare("SELECT * FROM Formations WHERE Date_Formation >= CURDATE()");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //-------------------- Récupérer toutes les séances d'un utilisateur --------------------//

    public function getAllSessionsForUser($userId) {
        $stmt = $this->db->prepare("SELECT f.* 
                                    FROM Formations f 
                                    JOIN Inscriptions_Formations i ON f.ID_Formation = i.ID_Formation
                                    WHERE i.ID_Utilisateur = ?");
        $stmt->execute([$userId]);
        $sessions = [];
        while ($row = $stmt->fetch()) {
            $sessions[] = new FormationModel($row);
        }
        return $sessions;
    }

    //-------------------- Récupérer toutes les séances à venir d'une formation --------------------//

    public function getUpcomingSessionsForFormation($formationId) {
        $stmt = $this->db->prepare("SELECT * FROM Formations WHERE ID_Formation = ? AND Date_Formation >= CURDATE()");
        $stmt->execute([$formationId]);
        $sessions = [];
        while ($row = $stmt->fetch()) {
            $sessions[] = new FormationModel($row);
        }
        return $sessions;
    }

    //-------------------- Vérifier la capacité de la salle --------------------//

    public function getRoomCapacity($roomName) {
        $stmt = $this->db->prepare("SELECT Capacite_Max FROM Salles WHERE Nom_Salle = ?");
        $stmt->execute([$roomName]);
        return $stmt->fetchColumn();
    }

    public function getNumberOfParticipantsInFormation($formationId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Inscriptions_Formations WHERE ID_Formation = ?");
        $stmt->execute([$formationId]);
        return $stmt->fetchColumn();
    }

    public function getAllFormationSessions($formationId)
    {
        $stmt = $this->db->prepare("SELECT * 
                                    FROM Seances 
                                    WHERE Seances.ID_Formation = :id");
        /*
        $result = $stmt->execute([$formationId]);
        $stmt = $this->db->prepare($sql);
        */
        $stmt->bindParam(':id', $formationId, PDO::PARAM_INT);
        $stmt->execute();

        $sessions = $stmt->fetch(PDO::FETCH_ASSOC);
//        $sessions = [];
        /*
        while ($row = $stmt->fetch()) {
            $sessions[] = new FormationModel($row);
        }*/
        return $sessions;
    }

    public function getAllInscriptions()
    {
        $stmt = $this->db->prepare("SELECT * 
                                    FROM Inscriptions_Formations 
                                    ");
        $stmt->execute();
        return $stmt->fetchAll();

//        $sessions = $stmt->fetch(PDO::FETCH_ASSOC);
//        $sessions = [];
        /*
        while ($row = $stmt->fetch()) {
            $sessions[] = new FormationModel($row);
        }*/
//        return $sessions;

    }
}
