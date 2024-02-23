<?php

include_once './Services/UserService.php';
include_once './Models/UserModel.php';
include_once './exceptions.php';
include_once './Repository/UserRepository.php';
include_once './Helpers/ResponseHelper.php';
include_once './Repository/BDD.php';

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


    public function createUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            ResponseHelper::sendResponse(["error" => "Invalid JSON"], 400);
            return;
        }

        try {
            $user = new UserModel($data);
            $user->validate($data);
            $user->hashPassword();
            $result = $this->userService->registerUser($user);
            ResponseHelper::sendResponse($result);
        } catch (Exception $e) {
            ResponseHelper::sendResponse(["error" => $e->getMessage()], $e->getCode());
        }
    }



    public function updateUser($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = new UserModel($data);
        $user->id_utilisateur = $id; // Make sure to set the user ID for update
        $result = $this->userService->updateUserProfile($user);
        ResponseHelper::sendResponse($result);
    }

    public function deleteUser($id) {
        $result = $this->userService->deleteUser($id);
        ResponseHelper::sendResponse($result);
    }
}

// Récupération de la méthode et des segments d'URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Création et traitement de la requête
$controller = new UserController();
$controller->processRequest($method, $uri);
