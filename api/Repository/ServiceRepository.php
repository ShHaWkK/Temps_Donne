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
        $query = "INSERT INTO Services (ID_Service, Nom_du_service, Description, Horaire, Lieu, NFC_Tag_Data, Date_Debut, Date_Fin, ID_ServiceType) VALUES (:id_service,:nom_du_service,:description,:horaire,:lieu,:nfc_tag_data,:date_debut,:date_fin, :id_serviceType)";
        $statement = $this->db->prepare($query);

        $statement->bindValue(':id_service', $service->id_service, PDO::PARAM_INT);
        $statement->bindValue(':nom_du_service', $service->nom_du_service, PDO::PARAM_STR);
        $statement->bindValue(':description', $service->description, PDO::PARAM_STR);
        $statement->bindValue(':horaire', $service->horaire, PDO::PARAM_STR);
        $statement->bindValue(':lieu', $service->lieu, PDO::PARAM_STR);
        $statement->bindValue(':nfc_tag_data', $service->nfc_Tag_Data, PDO::PARAM_STR);
        $statement->bindValue(':date_debut', $service->date_debut, PDO::PARAM_STR);
        $statement->bindValue(':date_fin', $service->date_fin, PDO::PARAM_STR);
        $statement->bindValue(':id_serviceType', $service->id_serviceType, PDO::PARAM_STR);

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

        return new serviceModel($service);
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
        $query = "SELECT * FROM Services";
        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
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

}

?>