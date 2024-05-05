<?php
require_once './Models/SkillModel.php'; // Assurez-vous que le chemin est correct
require_once './Repository/BDD.php';

class SkillRepository
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createSkill($skill)
    {
        $query = "INSERT INTO Competences (Nom_Competence, Description) VALUES (:nom_competence, :description)";
        $statement = $this->db->prepare($query);

        $statement->bindValue(':nom_competence', $skill['Nom_Competence'], PDO::PARAM_STR);
        $statement->bindValue(':description', $skill['Description'], PDO::PARAM_STR);

        $success = $statement->execute();

        if (!$success) {
            error_log("Erreur lors de la sauvegarde de la compétence : " . print_r($statement->errorInfo(), true));
            throw new Exception("Erreur lors de la sauvegarde de la compétence.");
        } else {
            $insertedId = $this->db->lastInsertId();
            error_log("ID de la compétence insérée : " . $insertedId);
            return $insertedId;
        }
    }

    public function getSkillById($id)
    {
        $sql = "SELECT * FROM Competences WHERE ID_Competence = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $skill = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$skill) {
            return null;
        }

        return new SkillModel($skill);
    }

    public function getAllSkills()
    {
        $query = "SELECT * FROM Competences";
        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserSkills($id_utilisateur)
    {
        try {
            $query = "SELECT * FROM UtilisateursCompetences WHERE ID_Utilisateur = :id_utilisateur";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des compétences de l'utilisateur : " . $e->getMessage());
        }
    }

    public function getUserSkillsDetails($ids_competences)
    {
        try {
            // Construire la clause IN pour la requête SQL en fonction des ID de compétences fournis
            $placeholders = rtrim(str_repeat('?,', count($ids_competences)), ',');
            $query = "SELECT * FROM Competences WHERE ID_Competence IN ($placeholders)";

            // Préparer la requête avec les paramètres dynamiques
            $statement = $this->db->prepare($query);

            // Liaison des valeurs des ID de compétences fournis avec les paramètres de la requête
            $i = 1;
            foreach ($ids_competences as $id_competence) {
                $statement->bindValue($i++, $id_competence, PDO::PARAM_INT);
            }

            // Exécuter la requête
            $statement->execute();

            // Récupérer les détails des compétences associées à l'utilisateur
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des détails des compétences de l'utilisateur : " . $e->getMessage());
        }
    }


    public function assignSkill($userID, $skillID)
    {
        try {
            $query = "INSERT INTO UtilisateursCompetences(ID_Utilisateur, ID_Competence) VALUES (:id_utilisateur, :id_competence) ";
            $statement = $this->db->prepare($query);
            $statement->bindParam(':id_utilisateur', $userID, PDO::PARAM_INT);
            $statement->bindParam(':id_competence', $skillID, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des compétences de l'utilisateur : " . $e->getMessage());
        }
    }

}
?>