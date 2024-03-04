<?php
//file : api/Services/UserService.php
require_once './Repository/UserRepository.php';
require_once './Models/UserModel.php';

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers() {
        return $this->userRepository->findAll();
    }

    public function findByEmail($email) {
        return $this->userRepository->findByEmail($email);
    }

    public function registerUser(UserModel $user) {
        $existingUser = $this->userRepository->findByEmail($user->email);
        if ($existingUser) {
            throw new Exception("Un compte avec cet email existe déjà.");
        }

        $user->hashPassword();
        $user->generateVerificationCode();
        $user->date_d_inscription = date('Y-m-d');
        $user->statut = true;

        $result = $this->userRepository->save($user);
        if ($user->role === 'Benevole') {
            $user->statut_benevole = 'En attente de validation';
            $this->assignRole($user->id_utilisateur, $roleIdForBenevole, 'En attente');
        }

        return $result;
    }

    public function deleteUser($userId) {
        return $this->userRepository->deleteUser($userId);
    }

    public function updateUserProfile(UserModel $user) {
        return $this->userRepository->updateUserProfile($user);
    }

    public function authenticateUser($email, $password) {
        $user = $this->userRepository->findByEmail($email);
        if ($user && password_verify($password, $user->mot_de_passe)) {
            $this->startUserSession($user);
            return $user;
        } else {
            throw new Exception("Identifiants incorrects.");
        }
    }

    private function startUserSession(UserModel $user) {
        session_start();
        $_SESSION['user'] = [
            'id' => $user->id_utilisateur,
            'email' => $user->email,
            'role' => $user->role
        ];
    }

    public function logout() {
        session_start();
        session_destroy();
    }

    // Gestion des rôles
    public function assignRole($userId, $roleId, $status = 'En attente') {
        return $this->userRepository->assignRole($userId, $roleId, $status);
    }

    public function getUserRoles($userId) {
        return $this->userRepository->getUserRoles($userId);
    }

    public function updateUserRole($userId, $roleId, $newStatus) {
        return $this->userRepository->updateUserRole($userId, $roleId, $newStatus);
    }
}

/*
require_once './Repository/UserRepository.php';
require_once './Models/UserModel.php';


class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers() {
        return $this->userRepository->findAll();
    }
    
    public function findByEmail($email) {
        return $this->userRepository->findByEmail($email);
    }

    public function registerUser(UserModel $user) {
        $existingUser = $this->userRepository->findByEmail($user->email);
        if ($existingUser) {
            throw new Exception("Un compte avec cet email existe déjà.");
        }
    
        $user->hashPassword();
        $user->generateVerificationCode();
        $user->date_d_inscription = date('Y-m-d');
        $user->statut = true; 
    
       $user->hashPassword();
       $user->generateVerificationCode();
       $user->date_d_inscription = date('Y-m-d');
       $user->statut = true; 

       if ($user->role === 'Benevole') {
           $user->statut_benevole = 'En attente de validation';
       }

       return $this->userRepository->save($user);
   }

    public function deleteUser($userId) {
        return $this->userRepository->deleteUser($userId);
    }

    public function updateUserProfile(UserModel $user) {
        return $this->userRepository->updateUserProfile($user);
    }
    

    public function authenticateUser($email, $password) {
        $user = $this->userRepository->findByEmail($email);

        if ($user && password_verify($password, $user->mot_de_passe)) {
            // Connectez l'utilisateur (par exemple, démarrez une session)
            $this->startUserSession($user);
            return $user;
        }

        // Gérez l'échec de l'authentification
        throw new Exception("Identifiants incorrects.");
    }

    private function startUserSession(UserModel $user) {
        session_start();
        $_SESSION['user'] = [
            'id' => $user->id_utilisateur,
            'email' => $user->email,
            'role' => $user->role
        ];
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}
*/