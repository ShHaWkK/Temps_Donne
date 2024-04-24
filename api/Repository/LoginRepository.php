<?php
// File : api/Repository/LoginRepository.php


class LoginRepository {

    public function __construct() {
    }

    public function findByCredentials($email, $password) {

        $hashed = hash("sha256", $password);

        $user = selectDB("Utilisateurs", "*", "Email='".$email."' AND Mot_de_passe='".$hashed."'")[0];

        if($user){

            $userTruc = new UserModel($user);
            exit_with_content($userTruc);
        }

        exit_with_message("Pas d'utilisateur correspondant dans la BDD");
    }
}


?>