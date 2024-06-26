<?php 

// file : api/Services/AdminService.php

require_once './Repository/AdminRepository.php';
require_once './Models/AdminModel.php';

class AdminService {
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository) {
        $this->adminRepository = $adminRepository;
    }

    public function getAllAdmins() {
        return $this->adminRepository->findAll();
    }

    public function getAdmin($id) {
        $admin = $this->adminRepository->findById($id);
        if (!$admin) {
            throw new Exception("Admin not found", 404);
        }
        return $admin;
    }

    public function findRoleIdByRoleName($roleName) {
        return $this->adminRepository->findRoleIdByRoleName($roleName);
    }

    public function registerAdmin(AdminModel $admin) {
        $admin->validate();
        $admin->hashPassword();
        if ($this->adminRepository->findByEmail($admin->email)) {
            throw new Exception("Email already exists", 400);
        }
        $this->adminRepository->save($admin);
    }

    public function deleteAdmin($id) {
        if (!$this->adminRepository->findById($id)) {
            throw new Exception("Admin not found", 404);
        }
        $this->adminRepository->deleteAdmin($id);
    }

    public function updateAdmin(AdminModel $admin) {
        if (!$this->adminRepository->findById($admin->id_admin)) {
            throw new Exception("Admin not found", 404);
        }
        if (!empty($admin->mot_de_passe)) {
            $admin->mot_de_passe = hash("sha256", $admin->mot_de_passe);
        }
        $admin->role = 'Administrateur';
        $this->adminRepository->updateAdmin($admin);
    }

    public function authenticateAdmin($email, $password) {
        $admin = $this->adminRepository->findByEmail($email);
        if ($admin && password_verify($password, $admin->mot_de_passe)) {
            return $admin;
        } else {
            throw new Exception("Invalid email or password", 401);
        }
    }

    //-------------- Validate Volunteer ----------//

    // public function validateVolunteer($userId) {
    //     $user = $this->adminRepository->findUserAndRoleById($userId, 'Benevole');
    //     if (!$user) {
    //         throw new Exception('Utilisateur non trouvé ou non éligible.', 404);
    //     }
    
    //     $this->adminRepository->validateUserRole($userId, 'Benevole', 'Validé');
    // }
    

    // public function refuseVolunteer($userId) {
    //     $user = $this->adminRepository->findUserAndRoleById($userId, 'Benevole');
    //     if (!$user) {
    //         throw new Exception('Utilisateur non trouvé ou non éligible.', 404);
    //     }

    //     $this->adminRepository->deleteUser($userId);

    // }

    /*
    public function ($userId) {
        // Appeler avec les bons paramètres selon la méthode consolidée dans AdminRepository
        $this->adminRepository->updateVolunteerStatus($userId, 'Approuvé', 'Approuvé');
    }*/

    public function validateUser(UserModel $user)
    {
        $user->statut = "Granted";
        $this->adminRepository->updateUserStatus($user);
        return $user;
    }

    public function holdUser(UserModel $user)
    {
        $user->statut = "Pending";
        $this->adminRepository->updateUserStatus($user);
        return $user;
    }

    public function rejectUser(UserModel $user)
    {
        $user->statut = "Denied";
        $this->adminRepository->updateUserStatus($user);
        return $user;
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}


?>
