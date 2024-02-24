<?php
// Path: api/Services/LoginService.php

class LoginService {
    private $loginRepository;

    public function __construct(LoginRepository $loginRepository) {
        $this->loginRepository = $loginRepository;
    }

    public function login($email, $password) {
        $user = $this->loginRepository->getUserByEmail($email);
        
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return null;
    }
}
?>
