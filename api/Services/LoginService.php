<?php
// File : api/Services/LoginService.php

require_once './Repository/UserRepository.php';
require_once './Repository/LoginRepository.php';

class LoginService {
    private $db;
    public function __construct($db) {
        $this->db=$db;
    }

    public function authenticate($email, $password, $role) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Format d'email invalide : " . $email);
        }

        // Valider le rôle
        if (!in_array($role, ['Benevole', 'Beneficiaire', 'Administrateur'])) {
            throw new InvalidArgumentException("Rôle invalide : $role");
        }

        $loginRepository = new LoginRepository($this->db);

        $userData = $loginRepository->findByCredentials($email, $password);
        if (!$userData) {
            throw new AuthenticationException("L'authentification a échoué. Informations d'identification incorrectes.");
        }
        // Vérifier le rôle de l'utilisateur
        if ($userData['Role'] !== $role) {
            throw new RoleException("L'utilisateur n'a pas le rôle requis pour cette opération.");
        }

        // Vérifier le rôle de l'utilisateur
        if ($userData['Statut'] !== 'Granted') {
            throw new StatusException("L'utilisateur n'a pas été validé.");
        }

        return $userData;
    }


    private function getRedirectUrlForRoles($roles) {
        foreach ($roles as $role) {
            if ($role === 'Administrateur') {
                return '/espace-admin_OLD';
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