<?php

require_once 'BDD.php';

class DemandeRepository {

    public function __construct() {
        $this->db = connectDB();
    }

    public function findAll() {
        $sql = "SELECT * FROM Demandes";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $sql = "SELECT * FROM Demandes WHERE ID_Demande = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($demande) {
        $dateDemande = date('Y-m-d H:i:s');
        $sql = is_null($demande['id_demande']) ?
            "INSERT INTO Demandes (ID_Utilisateur, ID_Service, Date_Demande, Statut) VALUES (:id_utilisateur, :id_serviceType, :date_demande, :statut)" :
            "UPDATE Demandes SET ID_Utilisateur = :id_utilisateur, ID_Service = :id_serviceType, Date_Demande = :date_demande, Statut = :statut WHERE ID_Demande = :id_demande";
        $stmt = $this->db->prepare($sql);
        if (!is_null($demande['id_demande'])) {
            $stmt->bindValue(':id_demande', $demande['id_demande'], PDO::PARAM_INT);
        }
        $stmt->bindValue(':id_utilisateur', $demande['id_utilisateur'], PDO::PARAM_INT);
        $stmt->bindValue(':id_serviceType', $demande['id_serviceType'], PDO::PARAM_INT);
        $stmt->bindValue(':date_demande', $dateDemande);
        $stmt->bindValue(':statut', $demande['statut']);
        $stmt->execute();
        return $demande['id_demande'] ? $demande['id_demande'] : $this->db->lastInsertId();
    }

    public function delete($id) {
        $sql = "DELETE FROM Demandes WHERE ID_Demande = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function assignBenevoleToDemande($id_demande, $id_benevole) {
        $sql = "INSERT INTO DemandesBenevoles (ID_Demande, ID_Utilisateur) VALUES (:id_demande, :id_benevole)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_demande', $id_demande, PDO::PARAM_INT);
        $stmt->bindValue(':id_benevole', $id_benevole, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addDemande($UserId, $ServiceId)
    {
        $dateDemande = date('Y-m-d H:i:s');
        $sql = "INSERT INTO Demandes (ID_Utilisateur, ID_ServiceType, Date_Demande) VALUES (:id_utilisateur, :id_serviceType, :date_demande)";
        $stmt=$this->db->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $UserId, PDO::PARAM_INT);
        $stmt->bindValue(':id_serviceType', $ServiceId, PDO::PARAM_INT);
        $stmt->bindValue(':date_demande',$dateDemande,PDO::PARAM_STR);

        $stmt->execute();
    }

    public function accepterDemande($demandeId)
    {
        $sql="UPDATE Demandes SET Statut = 'Acceptee' WHERE ID_Demande= :id";
        $stmt=$this->db->prepare($sql);
        $stmt->bindValue(':id',$demandeId,PD0::PARAM_INT);

        $stmt->execute();
    }
}
