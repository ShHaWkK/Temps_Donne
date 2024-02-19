<?php

require_once '../Models/AdminModel.php';
require_once '../Services/AdminService.php';


//-----------------Admin Controller-----------------//

class AdminController {
    private $authService;
    private $userService;
    private $adminModel;

    public function __construct() {
        $this->authService = new AuthService();
        $this->userService = new UserService();
        $this->adminModel = new AdminModel();
    }

    public function connexion($email, $mot_de_passe) {
        $admin = $this->serviceAuth->authentifier($email, $mot_de_passe);
        if ($admin) {
            return "Administrateur connecté avec succès";
        } else {
            return "Échec de la connexion";
        }
    }

//-----------------List Users Function-----------------//

    public function listUsers() {
        $this->authService->checkAuth();
        $users = $this->userService->getAllUsers();
        return $users;
    }

//-----------------Add User Function-----------------//

    public function addUser($userData) {
        $this->authService->checkAuth();

        $result = $this->userService->createUser($userData);
        return $result;
    }

//-----------------Delete User Function-----------------//

    public function deleteUser($userId) {
        $this->authService->checkAuth();
        $result = $this->userService->deleteUser($userId);
        return $result;
    }


}

// -----------------List Services Function-----------------//

    public function listServices() {
        $this->authService->checkAuth();

        $services = $this->adminModel->getAllServices();
        return $services;
    }

//-----------------Add Service Function-----------------//
    
    public function addService($serviceData) {
        $this->authService->checkAuth();
        $result = $this->adminModel->createService($serviceData);
        return $result;
    }

//-----------------Delete Service Function-----------------//

    public function deleteService($serviceId) {
        $this->authService->checkAuth();
        $result = $this->adminModel->deleteService($serviceId);
        return $result;
    }

//-----------------List Volunteers Function-----------------//

    public function listVolunteers() {
        $this->authService->checkAuth();
        $volunteers = $this->adminModel->getAllVolunteers();
        return $volunteers;
    }

//-----------------Add Volunteer Function-----------------//
    
    public function addVolunteer($volunteerData) {
        $this->authService->checkAuth();
        $result = $this->adminModel->createVolunteer($volunteerData);
        return $result;
    }

//-----------------Delete Volunteer Function-----------------//

    public function deleteVolunteer($volunteerId) {
        $this->authService->checkAuth();
        $result = $this->adminModel->deleteVolunteer($volunteerId);
        return $result;
    }

//-----------------List Beneficiaries Function-----------------//
    
    public function listBeneficiaries() {
        $this->authService->checkAuth();
        $beneficiaries = $this->adminModel->getAllBeneficiaries();
        return $beneficiaries;
    }

//-----------------Add Beneficiary Function-----------------//
        
     public function addBeneficiary($beneficiaryData) {
        $this->authService->checkAuth();
        $result = $this->adminModel->createBeneficiary($beneficiaryData);
        return $result;                
    }

//-----------------Delete Beneficiary Function-----------------//

    public function deleteBeneficiary($beneficiaryId) {
        $this->authService->checkAuth();
        $result = $this->adminModel->deleteBeneficiary($beneficiaryId);
        return $result;
    }



?>