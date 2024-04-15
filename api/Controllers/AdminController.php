<?php
// file: api/Controllers/AdminController.php

require_once './Services/AdminService.php';


class AdminController {
    //private $userService;
    private $adminService;


    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getAdmin($uri[3]);
                    } else {
                        $this->getAllAdmins();
                    }
                    break;
                case 'POST':
                    $this->registerAdmin();
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateAdmin($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteAdmin($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendResponse(['message' => 'Method Not Allowed'], 405);
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }


    public function __construct() {
        $db = connectDB();
        $adminRepository = new AdminRepository($db);
        $this->adminService = new AdminService($adminRepository);
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
        $adminRoleId = $this->adminService->findRoleIdByRoleName('Administrateur');
        if (!$adminRoleId) {
            ResponseHelper::sendResponse(["error" => "Role 'Administrateur' not found"], 400);
            return;
        }

        $data['role_id'] = $adminRoleId;
        $data['role'] = 'Administrateur';

        // Vérifiez que le mot de passe est présent et a au moins 8 caractères
        if (empty($data['mot_de_passe']) || strlen($data['mot_de_passe']) < 8) {
            ResponseHelper::sendResponse(["error" => "Le mot de passe est obligatoire et doit contenir au moins 8 caractères."], 400);
            return;
        }

        $admin = new AdminModel($data); //l'instance du modèle
        $this->adminService->registerAdmin($admin);
        ResponseHelper::sendResponse(['message' => 'Admin created successfully'], 201);
    }

    public function deleteAdmin($id) {
        $this->userService->deleteUser($id, 'Administrateur');
        ResponseHelper::sendResponse(['message' => 'Admin deleted successfully']);
    }

    public function updateAdmin($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $data['role'] = 'Administrateur';

        $admin = new UserModel($data);
        $admin->id_utilisateur = $id;
        $this->userService->updateUser($admin);
        ResponseHelper::sendResponse(['message' => 'Admin updated successfully']);
    }


    //--------------- Volunteer ------------------- //

    // public function validateVolunteer($userId) {
    //     try {
    //         $this->adminService->validateVolunteer($userId);
    //         ResponseHelper::sendResponse(['success' => 'Bénévole validé avec succès.']);
    //     } catch (Exception $e) {
    //         ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
    //     }
    // }

    // public function refuseVolunteer($userId) {
    //     try {
    //         $this->adminService->refuseVolunteer($userId);
    //         ResponseHelper::sendResponse(['success' => 'Bénévole refusé avec succès.']);
    //     } catch (Exception $e) {
    //         ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
    //     }
    // }

    public function approveVolunteer($userId) {
        try {
            $this->adminService->approveVolunteer($userId);
            ResponseHelper::sendResponse(['message' => 'Bénévole approuvé avec succès.']);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function holdVolunteer($userId) {
        try {
            $this->adminService->holdVolunteer($userId);
            ResponseHelper::sendResponse(['message' => 'Bénévole placé en attente.']);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function rejectVolunteer($userId) {
        try {
            $this->adminService->rejectVolunteer($userId);
            ResponseHelper::sendResponse(['message' => 'Bénévole rejeté avec succès.']);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

}
?>
