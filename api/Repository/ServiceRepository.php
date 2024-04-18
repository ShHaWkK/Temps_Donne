<?php
//file : api/Repository/UserRepository.php
require_once './Models/ServiceModel.php';
require_once './Repository/BDD.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class ServiceRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save(ServiceModel $service) {
        if (empty($service->type_service)) {
            throw new Exception("Le champ 'nom' ne peut pas être vide.");
        }

        $query = "INSERT INTO Services (ID_Service, Nom_du_service, Description, Horaire, Lieu, ID_Utilisateur, NFC_Tag_Data, Type_Service, Date_Debut, Date_Fin) VALUES (:id_service,:nom_du_service,:description,:horaire,:lieu,:id_utilisateur,:nfc_tag_data,:type_service,:date_debut,:date_fin)";
        $statement = $this->db->prepare($query);

        $statement->bindValue(':id_service', $service->id_service, PDO::PARAM_INT);
        $statement->bindValue(':nom_du_service', $service->nom_du_service, PDO::PARAM_STR);
        $statement->bindValue(':description', $service->description, PDO::PARAM_STR);
        $statement->bindValue(':horaire', $service->horaire, PDO::PARAM_STR);
        $statement->bindValue(':lieu', $service->lieu, PDO::PARAM_STR);
        $statement->bindValue(':id_utilisateur', $service->id_utilisateur, PDO::PARAM_INT);
        $statement->bindValue(':nfc_Tag_Data', $service->nfc_Tag_Data, PDO::PARAM_STR);
        $statement->bindValue(':type_service', $service->type_service, PDO::PARAM_STR);
        $statement->bindValue(':date_debut', $service->date_debut, PDO::PARAM_STR);
        $statement->bindValue(':date_fin', $service->date_fin, PDO::PARAM_STR);


        // Ajouter l'instruction de débogage juste avant d'exécuter la requête
        error_log("Sauvegarde du service : " . print_r($service, true));

        $success = $statement->execute();
        if (!$success) {
            error_log("Erreur lors de la sauvegarde de l'utilisateur : " . print_r($statement->errorInfo(), true));
            throw new Exception("Erreur lors de la sauvegarde de l'utilisateur.");
        } else {
            // Si l'exécution a réussi, obtenir l'ID inséré
            $insertedId = $this->db->lastInsertId();
            error_log("ID de l'utilisateur inséré : " . $insertedId);
            return $insertedId;
        }
    }
}

?>