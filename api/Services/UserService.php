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


    public function getAllUsers() {
        return $this->userRepository->findAll();
    }

    public function findByEmail($email) {
        return $this->userRepository->findByEmail($email);
    }

    // Peut être utile plus tard
    public function findByApikey($apikey) {
        return $this->userRepository->findByEmail($email);
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