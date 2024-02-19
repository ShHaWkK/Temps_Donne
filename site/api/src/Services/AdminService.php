<?php

//file : api/src/Services/AdminService.php
require_once 'Repository/AdminRepository.php';

class AdminService {
    private $adminRepository;

    public function __construct() {
        $this->adminRepository = new AdminRepository($db);
    }

    // Méthode pour authentifier un administrateur
    public function authenticate($email, $password) {
        $admin = $this->adminRepository->findAdminByEmail($email);

        if ($admin && password_verify($password, $admin['Mot_de_passe'])) {
            return $admin;
        }
        return null;
    }

    // Méthode pour récupérer tous les administrateurs
    public function getAllAdmins() {
        return $this->adminRepository->findAllAdmins();
    }

    // Ajouter d'autres méthodes nécessaires ici (création, mise à jour, suppression...)

    // Méthode pour créer un administrateur
    public function createAdmin($adminData) {
        return $this->adminRepository->createAdmin($adminData);
    }

    // Méthode pour mettre à jour un administrateur
    public function updateAdmin($adminData) {
        return $this->adminRepository->updateAdmin($adminData);
    }

    // Méthode pour supprimer un administrateur

    public function deleteAdmin($adminId) {
        return $this->adminRepository->deleteAdmin($adminId);
    }

    // Gestion des erreurs
    public function getErrors() {
        return $this->adminRepository->getErrors();
    }

    public function hasErrors() {
        return $this->adminRepository->hasErrors();
    }

    public function clearErrors() {
        return $this->adminRepository->clearErrors();
    }

    public function getError($error) {
        return $this->adminRepository->getError($error);
    }

}
?>

?>
