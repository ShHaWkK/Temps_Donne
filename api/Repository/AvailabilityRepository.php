<?php
require_once './Models/AvailabilityModel.php';
require_once './Repository/BDD.php';

class AvailabilityRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createAvailability($availability)
    {
        $query = "INSERT INTO Disponibilites (ID_Utilisateur, DEMI_JOURNEES, LUNDI, MARDI, MERCREDI, JEUDI, VENDREDI, SAMEDI, DIMANCHE) 
                  VALUES (:id_utilisateur, :demi_journees, :lundi, :mardi, :mercredi, :jeudi, :vendredi, :samedi, :dimanche)";
        $statement = $this->db->prepare($query);
        
        $statement->bindValue(':id_utilisateur', $availability->id_utilisateur, PDO::PARAM_INT);
        $statement->bindValue(':demi_journees', $availability->demi_journees, PDO::PARAM_INT);
        $statement->bindValue(':lundi', $availability->lundi, PDO::PARAM_BOOL);
        $statement->bindValue(':mardi', $availability->mardi, PDO::PARAM_BOOL);
        $statement->bindValue(':mercredi', $availability->mercredi, PDO::PARAM_BOOL);
        $statement->bindValue(':jeudi', $availability->jeudi, PDO::PARAM_BOOL);
        $statement->bindValue(':vendredi', $availability->vendredi, PDO::PARAM_BOOL);
        $statement->bindValue(':samedi', $availability->samedi, PDO::PARAM_BOOL);
        $statement->bindValue(':dimanche', $availability->dimanche, PDO::PARAM_BOOL);

        $success = $statement->execute();
        if (!$success) {
            throw new Exception("Error while saving availability.");
        } else {
            // If execution was successful, get the inserted ID
            return $this->db->lastInsertId();
        }
    }

    public function getAvailabilityById($id)
    {
        $sql = "SELECT * FROM Disponibilites WHERE ID_Disponibilite = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $availability = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$availability) {
            return null;
        }

        return new AvailabilityModel($availability);
    }

    public function getAvailabilityByUserId($id)
    {
        $sql = "SELECT * FROM Disponibilites WHERE ID_Utilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $availability = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$availability) {
            return null;
        }

        return new AvailabilityModel($availability);
    }

}
?>
