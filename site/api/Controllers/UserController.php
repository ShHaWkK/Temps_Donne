<?php

include_once './Services/UserService.php';
include_once './Models/UserModel.php';
include_once './exceptions.php';
include_once './Repository/UserRepository.php';
include_once './Helpers/ResponseHelper.php'; // Supposons que vous ayez un assistant pour formater les réponses

class UserController {
    private $userService;

    public function __construct() {
        $db = /* Initialisation de votre objet PDO ici */;
        $this->userService = new UserService(new UserRepository($db));
    }

    public function processRequest($method, $uri) {
        switch ($method) {
            case 'POST':
                $this->createUser();
                break;

            case 'PUT':
                $this->updateUser($uri[3]); // Supposons que l'ID de l'utilisateur soit le 4ème segment de l'URI
                break;

            case 'DELETE':
                $this->deleteUser($uri[3]);
                break;

            default:
                ResponseHelper::sendNotFound();
        }
    }

    private function createUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = new UserModel($data);
        // Valider et préparer les données ici
        $result = $this->userService->registerUser($user);
        ResponseHelper::sendResponse($result);
    }

    private function updateUser($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = $this->userService->getUserById($id);
        if (!$user) {
            ResponseHelper::sendNotFound("Utilisateur non trouvé.");
            return;
        }
        // Mettre à jour les propriétés ici
        $result = $this->userService->updateUserProfile($user);
        ResponseHelper::sendResponse($result);
    }

    private function deleteUser($id) {
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
