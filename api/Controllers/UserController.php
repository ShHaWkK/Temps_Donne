<?php

require_once './Services/UserService.php';
require_once './Models/UserModel.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';

class UserController {
    public $userService;

    public function __construct() {
        $db = connectDB();
        $userRepository = new UserRepository($db);
        $this->userService = new UserService($userRepository);
    }

    public function processRequest($method, $uri) {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getUser($uri[3]);
                    } else {
                        $this->getAllUsers();
                    }
                    break;
                case 'POST':
                    if ($uri[2] === 'register') {
                        $this->createUser();
                    } elseif ($uri[2] === 'volunteers') {
                        $this->registerVolunteer();
                    }
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateUser($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteUser($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendNotFound();
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
    public function getUser($id) {
        var_dump("userController : getUserId");
        // Vérification du rôle
        if (!$this->checkRole('admin')) {
            throw new Exception("Accès non autorisé.");
        }

        // Récupération de l'utilisateur
        $user = $this->userService->getUserById($id);
        if (!$user) {
            ResponseHelper::sendNotFound("User not found.");
        } else {
            ResponseHelper::sendResponse($user);
        }
    }


    private function checkRole($requiredRole) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        $user = $this->userService->getUserById($_SESSION['user_id']);
        return $user->role_effectif === $requiredRole;
    }

    public function getAllUsers() {
        $users = $this->userService->getAllUsers();
        ResponseHelper::sendResponse($users);
    }

    public function createUser() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        try {
            $user = new UserModel($data);
            $user->validate($data);

            if ($this->userService->emailExists($user->email)) {
                throw new Exception("Email déjà utilisé.", 400);
            }

            $user->hashPassword();
            $roleId = null;

            if (isset($data['role_name'])) {
                $roleId = $this->userService->findRoleIdByRoleName($data['role_name']);
                if (!$roleId) {
                    throw new Exception("Rôle non trouvé.");
                }
            } else {
                throw new Exception("Le rôle est obligatoire.", 400);
            }

            $this->userService->registerUser($user, $roleId);

            ResponseHelper::sendResponse(["success" => "Le compte a bien été créé."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }
    

    //-------------------- Delete User -------------------//
    public function deleteUser($id) {
        try {
            $result = $this->userService->deleteUser($id);
            if ($result) {
                ResponseHelper::sendResponse(['success' => 'Utilisateur supprimé avec succès.']);
            } else {
                ResponseHelper::sendNotFound('Utilisateur non trouvé.');
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Update User -------------------//
    public function updateUser($id) {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            ResponseHelper::sendResponse(["error" => "Invalid JSON: " . json_last_error_msg()], 400);
            return;
        }

        try {
            $user = new UserModel($data);
            $user->id_utilisateur = $id;
            $this->userService->updateUserProfile($user);
            ResponseHelper::sendResponse(["success" => "Utilisateur mis à jour avec succès."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Volunteer Registration -------------------//

    public function registerVolunteer() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        error_log(print_r($data, true));

        try {
            $user = new UserModel($data);
            $user->validate($data);
            $user->hashPassword();
            $roleId = $this->userService->findRoleIdByRoleName('Benevole');
            // Vous devez gérer $user->statut_benevole dans UserService
            $this->userService->registerVolunteer($user);

            ResponseHelper::sendResponse(["success" => "Inscription du bénévole réussie. En attente de validation."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }

    //-------------------- Access Control -------------------//
    public function accessVolunteerSpace($userId) {
        if (!$this->userService->checkVolunteerStatus($userId)) {
            throw new Exception("Accès non autorisé. Bénévole non validé.");
        }
        // Logique pour accéder à l'espace privé du bénévole
        ResponseHelper::sendResponse(["message" => "Accès autorisé. Bienvenue dans votre espace bénévole."]);
        
    }
    
}