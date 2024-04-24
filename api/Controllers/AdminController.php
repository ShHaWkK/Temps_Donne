<?php
// file: api/Controllers/AdminController.php
require_once 'UserController.php';
require_once './Services/AdminService.php';


class AdminController {
    //private $userService;
    private $adminService;
    private $userService;

    public function processRequest($requestMethod,$uri,$userController)
    {
        switch ($requestMethod) {
            case 'GET':
                if (isset($uri[3])) {
                    $this->getAdmin($uri[3]);
                } else {
                    $this->getAllAdmins();
                }
                break;
            case 'POST':

                break;
            case 'PUT':
                if (isset($uri[3]) && isset($uri[4])) {
                    switch ($uri[4]) {
                        case 'approve':
                            $this->approveUser($uri[3],$userController);
                            break;
                        case 'hold':
                            $this->holdUser($uri[3],$userController);
                            break;
                        case 'reject':
                            $this->rejectUser($uri[3],$userController);
                            break;
                        default:
                            sendJsonResponse(['message' => 'Action Not Found'], 404);
                    }
                } else if (isset($uri[3])) {
                    //$controller->updateAdmin($uri[3]);
                }
                break;
            case 'DELETE':
                if (isset($uri[3])) {
                    $this->deleteAdmin($uri[3]);
                }
                break;
            default:
                sendJsonResponse(['message' => 'Method Not Allowed'], 405);
                break;
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

    //-------------------- Volunteer and Beneficiary Approval -------------------//
    public function approveUser($id,$userController)
    {
        try {
            $user = $userController->userService->getUserById($id);
            if (!$user) {
                ResponseHelper::sendResponse(["error" => "Utilisateur non trouvé."], 404);
                return;
            }

            $user = $this->adminService->validateUser($user);

            ResponseHelper::sendResponse(["success" => "Utilisateur validé avec succès.", "statut" => $user->statut]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    public function approveBeneficiary($id,$userController)
    {
        try {
            $user = $userController->userService->getUserById($id);

            if (!$user) {
                ResponseHelper::sendResponse(["error" => "Utilisateur non trouvé."], 404);
                return;
            }

            $user = $this->adminService->validateUser($user);

            ResponseHelper::sendResponse(["success" => "Utilisateur validé avec succès.", "statut" => $user->statut]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Volunteer and Beneficiary put on hold -------------------//

    public function holdUser($id,$userController)
    {
        try {
            $user = $userController->userService->getUserById($id);

            if (!$user) {
                ResponseHelper::sendResponse(["error" => "Utilisateur non trouvé."], 404);
                return;
            }

            $user = $this->adminService->holdUser($user);

            ResponseHelper::sendResponse(["success" => "Utilisateur mis en attente avec succès.", "statut" => $user->statut]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    public function rejectUser($id,$userController)
    {
        try {
            $user = $userController->userService->getUserById($id);

            if (!$user) {
                ResponseHelper::sendResponse(["error" => "Utilisateur non trouvé."], 404);
                return;
            }

            $user = $this->adminService->rejectUser($user);

            ResponseHelper::sendResponse(["success" => "Utilisateur refusé avec succès.", "statut" => $user->statut]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

}
?>
