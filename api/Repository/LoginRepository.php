<?php
// File : api/Repository/LoginRepository.php
class LoginRepository {

    public function __construct() {
    }

    public function findByCredentials($email, $password) {

        $hashed = hash("sha256", $password);

        $user = selectDB("Utilisateurs", "*", "Email='".$email."' AND Mot_de_passe='".$hashed."'")[0];

        if($user){
            return $user; // Retourner les données de l'utilisateur
        }

        return null; // Aucun utilisateur trouvé
    }
}
?>