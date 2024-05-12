<?php
// File : api/Repository/LoginRepository.php
class LoginRepository {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByCredentials($email, $password)
    {
        $hashed = hash("sha256", $password);
        $user = selectDB("Utilisateurs", "*", "Email='".$email."' AND Mot_de_passe='".$hashed."'")[0];
        if($user){
            return $user;
        }
        return null; // Aucun utilisateur trouvé
    }

    public function getUserIdBySessionToken($session_token)
    {
        $query = "SELECT ID_Utilisateur FROM Session WHERE Session_Token = :session_token";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':session_token', $session_token);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['ID_Utilisateur'];
        } else {
            return null;
        }
    }


    public function storeSessionToken($id_utilisateur, $session_token)
    {
        $query="INSERT INTO Session(ID_Utilisateur,Session_Token)
        VALUES (:id_utilisateur, :session_token)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->bindValue(':session_token',$session_token);

        $success = $stmt->execute();
        if (!$success) {
            error_log("Erreur lors de la sauvegarde du token de connexion : " . print_r($stmt->errorInfo(), true));
            throw new Exception("Erreur lors de la sauvegarde du token de connexion.");

        } else {
            // Si l'exécution a réussi, obtenir l'ID inséré
            $insertedId = $this->db->lastInsertId();
            error_log("ID du token inséré : " . $insertedId);
            return $insertedId;
        }
    }
}
?>