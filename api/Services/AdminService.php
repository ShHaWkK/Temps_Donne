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

    public function registerAdmin(AdminModel $admin) {
        if ($this->adminRepository->findByEmail($admin->email)) {
            throw new Exception("Email already exists", 400);
        }
        $admin->mot_de_passe = password_hash($admin->mot_de_passe, PASSWORD_DEFAULT);
        $role = 'Administrateur';
        $admin->setRole($role);
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
            $admin->mot_de_passe = password_hash($admin->mot_de_passe, PASSWORD_DEFAULT);
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

    public function logout() {
        session_start();
        session_destroy();
    }
}


?>
