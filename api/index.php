<?php
// file: api/index.php

//header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'Controllers/UserController.php';
require_once 'Repository/UserRepository.php';
require_once 'Services/UserService.php'; 

error_reporting(E_ERROR | E_PARSE);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

function exitWithError($message = "Internal Server Error", $code = 500) {
    http_response_code($code);
    echo json_encode(['message' => $message]);
    exit();
}

function router($uri) {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $controller = null;

    if (isset($uri[2])) {
        switch ($uri[2]) {
            case 'admins':
                // Assurez-vous que seul un administrateur peut accéder à cette route
                $controller = new AdminController();
                break;
            case 'users':
                $controller = new UserController();
                switch ($requestMethod) {
                    case 'GET':
                        if (isset($uri[3])) {
                            $controller->getUser($uri[3]);
                        } else {
                            $controller->getAllUsers();
                        }
                        break;
                    case 'POST':
                        $controller->createUser();
                        break;
                    case 'PUT':
                        if (isset($uri[3])) {
                            $controller->updateUser($uri[3]);
                        }
                        break;
                    case 'DELETE':
                        if (isset($uri[3])) {
                            $controller->deleteUser($uri[3]);
                        }
                        break;
                    default:
                        ResponseHelper::sendNotFound();
                        break;
                }
                break;
            case 'volunteers':
                $controller = new UserController();
                if ($requestMethod == 'POST' && isset($uri[3]) && $uri[3] == 'register') {
                    $controller->registerVolunteer();
                } else {
                    exitWithError('Method Not Allowed', 405);
                }
                break;
                case 'login':
                    $loginService = new LoginService(new LoginRepository(connectDB()));
                    $loginController = new LoginController($loginService);
                    if ($requestMethod == 'POST') {
                        // Récupérer les données de la requête POST
                        $email = $_POST['email'] ?? null;
                        $password = $_POST['password'] ?? null;
                        if ($email && $password) {
                            // Effectuer la connexion
                            $loginController->login($email, $password);
                        } else {
                            exitWithError('Email and password are required.', 400);
                        }
                        } else {
                        exitWithError('Method Not Allowed', 405);
                    }
                    break;
            default:
                exitWithError('Not Found', 404);
                break;
        }
    } else {
        exitWithError('Not Found', 404);
    }
}

router($uri);
?>
