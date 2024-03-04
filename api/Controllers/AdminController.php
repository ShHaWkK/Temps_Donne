<?php
// file: api/Controllers/AdminController.php

require_once './Services/UserService.php'; 
require_once './Models/UserModel.php';
require_once './Helpers/ResponseHelper.php';

class AdminController {
    private $userService; // Remarque: userService au lieu de adminService

    public function __construct() {
        $db = connectDB();
        $userRepository = new UserRepository($db);
        $this->userService = new UserService($userRepository);
    }

    public function getAllAdmins() {
        $admins = $this->userService->getAllUsersByRole('Administrateur');
        ResponseHelper::sendResponse($admins);
    }

    public function getAdmin($id) {
        $admin = $this->userService->getUserByIdAndRole($id, 'Administrateur');
        if (!$admin) {
            ResponseHelper::sendNotFound("Admin not found.");
        } else {
            ResponseHelper::sendResponse($admin);
        }
    }

    public function registerAdmin() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Vérifiez que le mot de passe est présent et a au moins 8 caractères
        if (empty($data['mot_de_passe']) || strlen($data['mot_de_passe']) < 8) {
            ResponseHelper::sendResponse(["error" => "Le mot de passe est obligatoire et doit contenir au moins 8 caractères."], 400);
            return;
        }


        $adminRoleId = 3; 
        $data['role'] = 'Administrateur'; 

        $admin = new UserModel($data);
        $this->userService->registerUser($admin, $adminRoleId);
        ResponseHelper::sendResponse(['message' => 'Admin created successfully'], 201);
    }



    public function deleteAdmin($id) {
        $this->userService->deleteUser($id, 'Administrateur');
        ResponseHelper::sendResponse(['message' => 'Admin deleted successfully']);
    }

    public function updateAdmin($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $data['role'] = 'Administrateur'; // Assurez-vous que le rôle est 'Administrateur'

        $admin = new UserModel($data);
        $admin->id_utilisateur = $id;
        $this->userService->updateUser($admin);
        ResponseHelper::sendResponse(['message' => 'Admin updated successfully']);
    }
}
?>
