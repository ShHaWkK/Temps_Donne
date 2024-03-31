<?php
// File : api/Services/LoginService.php

require_once './Repository/UserRepository.php';
require_once './Repository/LoginRepository.php';

class LoginService {
    private $userRepository;
    private $loginRepository;
    public function __construct() {
        $db = connectDB();
        $this->userRepository = new UserRepository($db);
        $this->loginRepository = new LoginRepository($db);
    }

    public function authenticate($email, $password) {
        $user = $this->loginRepository->findByCredentials($email, $password);
    
        if ($user) {
            $roles = $this->loginRepository->findRolesByUserId($user['ID_Utilisateur']);
    
            if (empty($roles)) {
                throw new Exception("Aucun rôle attribué à cet utilisateur", 401);
            }
    
            $sessionData = [
                'user_id' => $user['ID_Utilisateur'],
                'roles' => $roles,
                'redirect' => $this->getRedirectUrlForRoles($roles)
            ];
    
            return $sessionData;
        }
    
        throw new Exception("Identifiants incorrects");
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