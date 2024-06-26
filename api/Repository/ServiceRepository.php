<?php
//file : api/Repository/UserRepository.php
require_once './Models/ServiceModel.php';
require_once './Models/ServiceTypeModel.php';
require_once './Repository/BDD.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class ServiceRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createService($service)
    {
        $query = "INSERT INTO Services (Nom_du_service, Description, Lieu, Date, ID_ServiceType, startTime, endTime) 
              VALUES (:nom_du_service, :description, :lieu, :date, :id_serviceType, :startTime, :endTime)";
        $statement = $this->db->prepare($query);

        $statement->bindValue(':nom_du_service', $service->nom_du_service, PDO::PARAM_STR);
        $statement->bindValue(':description', $service->description, PDO::PARAM_STR);
//        $statement->bindValue(':horaire', $service->horaire, PDO::PARAM_STR);
        $statement->bindValue(':lieu', $service->lieu, PDO::PARAM_STR);
        $statement->bindValue(':date', $service->date, PDO::PARAM_STR);
        $statement->bindValue(':id_serviceType', $service->id_serviceType, PDO::PARAM_INT);
        $statement->bindValue(':startTime', $service->startTime, PDO::PARAM_STR);
        $statement->bindValue(':endTime', $service->endTime, PDO::PARAM_STR);

        // Ajouter l'instruction de débogage juste avant d'exécuter la requête
        error_log("Sauvegarde du service : " . print_r($service, true));

        $success = $statement->execute();

        if (!$success) {
            error_log("Erreur lors de la sauvegarde du service : " . print_r($statement->errorInfo(), true));
            throw new Exception("Erreur lors de la sauvegarde du service.");
        } else {
            // Si l'exécution a réussi, obtenir l'ID inséré
            $insertedId = $this->db->lastInsertId();
            error_log("ID du service inséré : " . $insertedId);
            return $insertedId;
        }
    }

    public function getServiceById($id)
    {
        $sql = "SELECT * FROM Services WHERE ID_Service = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $service = $stmt->fetch(PDO::FETCH_ASSOC);
        $data = array_change_key_case($service, CASE_LOWER);

        if (!$service) {
            return null;
        }

        return $service;
    }

    public function getServiceTypeById($id)
    {
        $sql = "SELECT * FROM ServiceType WHERE ID_ServiceType = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $serviceType = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$serviceType) {
            return null;
        }

        return new serviceTypeModel($serviceType);
    }

    public function updateService(serviceModel $service, array $fieldsToUpdate)
    {
        $query = "UPDATE Services SET ";
        $sets = [];
        $params = [];
        foreach ($fieldsToUpdate as $field) {
            $sets[] = "$field = :$field";
            $params[":$field"] = $service->$field;
        }

        $query .= implode(", ", $sets);
        $query .= " WHERE ID_Service = :id_service";
        $params[":id_service"] = $service->id_service;

        $statement = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        return $statement->execute();
    }

    public function deleteService($id)
    {
        try {
            $sql = "DELETE FROM Services WHERE ID_Service = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression du service : " . $e->getMessage());
        }
    }

    public function getAllServices()
    {
        try{
            $query = "SELECT * FROM Services";
            $statement = $this->db->prepare($query);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des services : " . $e->getMessage());
        }

    }

    public function getAllServiceTypes()
    {
        try {
            $query = "SELECT * FROM ServiceType";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la récupération du type de service : " . $e->getMessage());
        }
    }

    public function getServicesByType($id_type)
    {
        try {
            $query = "SELECT * FROM Services WHERE ID_ServiceType = :id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id', $id_type, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la récupération du type de service : " . $e->getMessage());
        }
    }
}

?>