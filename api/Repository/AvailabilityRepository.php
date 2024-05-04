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
                  VALUES (:id_user, :half_days, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday)";
        $statement = $this->db->prepare($query);

        $statement->bindValue(':id_user', $availability->id_user, PDO::PARAM_INT);
        $statement->bindValue(':half_days', $availability->half_days, PDO::PARAM_INT);
        $statement->bindValue(':monday', $availability->monday, PDO::PARAM_BOOL);
        $statement->bindValue(':tuesday', $availability->tuesday, PDO::PARAM_BOOL);
        $statement->bindValue(':wednesday', $availability->wednesday, PDO::PARAM_BOOL);
        $statement->bindValue(':thursday', $availability->thursday, PDO::PARAM_BOOL);
        $statement->bindValue(':friday', $availability->friday, PDO::PARAM_BOOL);
        $statement->bindValue(':saturday', $availability->saturday, PDO::PARAM_BOOL);
        $statement->bindValue(':sunday', $availability->sunday, PDO::PARAM_BOOL);

        $success = $statement->execute();
        if (!$success) {
            throw new Exception("Error while saving availability.");
        } else {
            // If execution was successful, get the inserted ID
            $insertedId = $this->db->lastInsertId();
            return $insertedId;
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
