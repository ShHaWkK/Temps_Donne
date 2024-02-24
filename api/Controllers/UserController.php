<?php

require_once './Services/UserService.php';
require_once './Models/UserModel.php';
require_once './exceptions.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/BDD.php';

class UserController {
    private $userService;
    

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
                    $this->createUser();
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

    public function getAllUsers() {
        $users = $this->userService->getAllUsers();
        ResponseHelper::sendResponse($users);
    }

    public function getUser($id) {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            ResponseHelper::sendNotFound("User not found.");
        } else {
            ResponseHelper::sendResponse($user);
        }
    }

    // private function createUser() {
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     $user = new UserModel($data);
    //     $user->validate($data);
    //     $user->hashPassword();
    //     $result = $this->userService->registerUser($user);
    //     ResponseHelper::sendResponse($result);
    // }


    // public function createUser() {
    //     $json = file_get_contents("php://input");
    //     $data = json_decode($json, true);
    
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         ResponseHelper::sendResponse(["error" => "Invalid JSON: " . json_last_error_msg()], 400);
    //         return;
    //     }
    
    //     try {
    //         $user = new UserModel($data);
    //         $user->validate($data); 
    //         $user->hashPassword();
    //         $result = $this->userService->registerUser($user);
    
    //         // Ne créez pas l'utilisateur si une exception a été levée avant cette ligne
    //         $roleMessage = $user->role === 'Bénévole' ? 'Bénévole' : 'Bénéficiaire';
    //         ResponseHelper::sendResponse(["success" => "Le compte a bien été créé en tant que " . $roleMessage]);
    //     } catch (Exception $e) {
    //         // Si une exception est levée, envoyez l'erreur, ne continuez pas le processus
    //         ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
    //         return;
    //     }
    // }
    
    public function createUser() {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            ResponseHelper::sendResponse(["error" => "Invalid JSON: " . json_last_error_msg()], 400);
            return;
        }

        try {
            $user = new UserModel($data);
            $user->validate($data);

            if ($this->userService->findByEmail($user->email)) {
                ResponseHelper::sendResponse(["error" => "Un compte avec cet email existe déjà."], 400);
                return;
            }

            $user->hashPassword();
            $result = $this->userService->registerUser($user);

            $roleMessage = $user->role === 'Bénévole' ? 'Bénévole' : 'Bénéficiaire';
            ResponseHelper::sendResponse(["success" => "Le compte a bien été créé en tant que " . $roleMessage]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }
    

    // //-
    // public function updateUser($id) {
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     $user = new UserModel($data);
    //     $user->id_utilisateur = $id; // Make sure to set the user ID for update
    //     $result = $this->userService->updateUserProfile($user);
    //     ResponseHelper::sendResponse($result);
    // }

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

        if (json_last_error() !== JSON_ERROR_NONE) {
            ResponseHelper::sendResponse(["error" => "Invalid JSON: " . json_last_error_msg()], 400);
            return;
        }

        try {
            $user = new UserModel($data);
            $user->role = 'Benevole'; // Définir le rôle comme bénévole
            $user->validate($data);
            $this->userService->registerUser($user);
            ResponseHelper::sendResponse(["success" => "Inscription du bénévole réussie et en attente de validation."]);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }
}

// Récupération de la méthode et des segments d'URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Création et traitement de la requête
$controller = new UserController();
$controller->processRequest($method, $uri);