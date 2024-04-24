<?php
//file : api/Services/UserService.php
require_once './Repository/UserRepository.php';
require_once './Models/UserModel.php';
require_once './Helpers/ResponseHelper.php';

class UserService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function authenticateAdmin($email, $password) {
        return $this->authenticateRole($email, $password, 'Administrateur');
    }

    public function authenticateVolunteer($email, $password) {
        return $this->authenticateRole($email, $password, 'Benevole');
    }

    public function authenticateBeneficiary($email, $password) {
        return $this->authenticateRole($email, $password, 'Beneficiaire');
    }

    // private function authenticateRole($email, $password, $roleName) {
    //     $user = $this->userRepository->findByEmail($email);
    //     if (!$user) {
    //         throw new AuthenticationException("Utilisateur non trouvé");
    //     }
    //     if (!password_verify($password, $user->mot_de_passe)) {
    //         throw new AuthenticationException("Mot de passe incorrect");
    //     }
    //     $roles = $this->userRepository->getUserRoles($user->id_utilisateur);
    //     if (!in_array($roleName, $roles)) {
    //         throw new RoleException("Rôle non autorisé");
    //     }
    //     return $user;
    // }

    public function authentificate($email, $password, $role)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new AuthenticationException("Utilisateur non trouvé");
        }
        var_dump($password);
        var_dump($user->mot_de_passe);
        if (!password_verify($password, $user->mot_de_passe)) {
            throw new AuthenticationException("Mot de passe incorrect");
        }

        /*
        $roles = $this->userRepository->getUserRoles($user->id_utilisateur);
        if (!in_array($role, $roles)) {
            throw new RoleException("Rôle non autorisé");
        }*/

        if($role != $user->role){
            throw new RoleException("Le role ne correspond pas");
        }

        return $user;
    }


    public function getAllUsers() {
        return $this->userRepository->findAll();
    }

    public function findByEmail($email) {
        return $this->userRepository->findByEmail($email);
    }
    public function createUserWithRole($userData, $roleName) {
        return $this->userRepository->createUserWithRole($userData, $roleName);
    }

    public function registerUser(UserModel $user) {
        // Vérifier si l'utilisateur existe déjà
        $existingUser = $this->userRepository->findByEmail($user->email);
        if ($existingUser) {
            throw new Exception("Un compte avec cet email existe déjà.");
        }
    
        // Hachage du mot de passe et autres préparations
        $user->hashPassword();
        $user->generateVerificationCode();
        $user->date_d_inscription = date('Y-m-d');
        $user->statut = true;
    
        // Enregistrement de l'utilisateur
        $userId = $this->userRepository->save($user);
    
        // Trouver l'ID du rôle
        /*
        $roleId = $this->userRepository->findRoleIdByRoleName($roleName);
        if (!$roleId) {
            throw new Exception("Rôle non trouvé.");
        }*/
    
        // Assignation du rôle à l'utilisateur
        //$user->role=$roleName;
        //$this->userRepository->assignRoleToUser($userId, $roleId, 'Actif');
        $user->statut='pending';

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
        /*
         $roleId = $this->userRepository->findRoleIdByRoleName('Benevole');
        if (!$roleId) {
            throw new Exception("Rôle 'Benevole' non trouvé.");
        }
        */
    
        // Assign the role to the user
        //$this->userRepository->assignRoleToUser($userId, $roleId, 'Pending'); // Status 'En attente'
        $user->role = 'Benevole';
        $user->statut ='pending';

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

    public function checkVolunteerStatus($userId) {
        // Vérifier le statut du bénévole
        $user = $this->userRepository->findByUserId($userId);
        return $user->statut_benevole === 'validé';
    }


    public function logout() {
        session_start();
        session_destroy();
    }

    // Gestion des rôles
    public function assignRole($userId, $roleId, $status = 'Pending') {
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

    public function emailExists($email) {
        $user = $this->userRepository->findByEmail($email);
        return $user !== null;
    }

    public function getUserById($id) {
        try {
            return $this->userRepository->getUserById($id);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        }
    }

    public function getAllUsersByRole($role)
    {
        return $this->userRepository->getAllUsersByRole($role);
    }

    public function getAllUsersByRoleAndStatus($role,$statut){
        try {
            return $this->userRepository->getAllUsersByRoleAndStatus($role,$statut);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
        }
    }

    public function updateUser(?UserModel $user, array $fieldsToUpdate)
    {
        return $this->userRepository->updateUser($user,$fieldsToUpdate);
    }


}