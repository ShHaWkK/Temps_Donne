<?php
// File : api/Services/LoginService.php

require_once './Repository/UserRepository.php';
require_once './Repository/LoginRepository.php';

class LoginService {
    public function __construct() {
    }

    public function authenticate($email, $password) {

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            exit_with_message("Mauvais format d'email");
        }


        $loginRepository = new LoginRepository();
        $loginRepository->findByCredentials($email, $password);

    }

    private function getRedirectUrlForRoles($roles) {
        foreach ($roles as $role) {
            if ($role === 'Administrateur') {
                return '/espace-admin';
            } elseif ($role === 'Benevole') {
                return '/espace-benevole';
            } elseif ($role === 'Beneficiaire') {
                return '/espace-beneficiaire';
            }
        }
        return '/';
    }
}

?>