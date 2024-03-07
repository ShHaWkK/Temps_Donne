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

    public function registerUser(UserModel $user, $roleName) {
        $existingUser = $this->userRepository->findByEmail($user->email);
        
        $user->hashPassword();
        $user->generateVerificationCode();
        $user->date_d_inscription = date('Y-m-d');
        $user->statut = true;
        
        $userId = $this->userRepository->save($user);
        
        $roleId = $this->userRepository->findRoleIdByRoleName($roleName);
        if (!$roleId) {
            throw new Exception("Rôle non trouvé.");
        }
        
        $this->userRepository->assignRoleToUser($userId, $roleId, 'Actif');
        
        return $userId;
    }

    public function registerVolunteer(UserModel $user) {
        // Check if the email already exists
        $existingUser = $this->userRepository->findByEmail($user->email);
        if ($existingUser) {
            throw new Exception("Un compte avec cet email existe déjà.");
        }
    
        // Hash the password and generate a verification code
        $user->hashPassword();
        $user->generateVerificationCode();
        $user->date_d_inscription = date('Y-m-d');
        $user->statut = true;  // Active by default
    
        // Save the user and get the ID
        $userId = $this->userRepository->save($user);
    
        // Find the role ID for 'Benevole'
        $roleId = $this->userRepository->findRoleIdByRoleName('Benevole');
        if (!$roleId) {
            throw new Exception("Rôle 'Benevole' non trouvé.");
        }
    
        // Assign the role to the user
        $this->userRepository->assignRoleToUser($userId, $roleId, 'En attente'); // Status 'En attente'
    
        return $userId; // Return the user ID or any other success indicator
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
        $this->userRepository->assignRoleToUser($userId, $roleId, $status);
    }

    public function getUserRoles($userId) {
        return $this->userRepository->getUserRoles($userId);
    }

    public function updateUserRole($userId, $roleId, $newStatus) {
        $this->userRepository->updateUserRole($userId, $roleId, $newStatus);
    }

    public function findRoleIdByRoleName($roleName) {
        return $this->userRepository->findRoleIdByRoleName($roleName);
    }

}