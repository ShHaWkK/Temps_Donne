<?php

// file: api/index.php

//header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'Controllers/AdminController.php';
require_once 'Controllers/UserController.php';
require_once 'Helpers/ResponseHelper.php';

error_reporting(E_ERROR | E_PARSE);

$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requestMethod = $_SERVER['REQUEST_METHOD'];

function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit();
}

function router($uri, $requestMethod) {
    if (!isset($uri[2])) {
        sendJsonResponse(['message' => 'Not Found'], 404);
        return;
    }

    switch ($uri[2]) {

        case 'admins':
            $controller = new AdminController();
            break;
        case 'users':
            $controller = new UserController();
            break;
        default:
            sendJsonResponse(['message' => 'Not Found'], 404);
            return;
    }

    try {
        switch ($requestMethod) {
            case 'GET':
                if (isset($uri[3])) {
                    $controller->getUser($uri[3]);
                } else {
                    $controller->getAllUsers();
                }
                break;
            case 'POST':
                if ($uri[2] === 'volunteers') {
                    $controller->registerVolunteer();
                } else {
                    $controller->registerAdmin();
                }
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
                sendJsonResponse(['message' => 'Method Not Allowed'], 405);
                break;
        }
    } catch (Exception $e) {
        sendJsonResponse(['error' => $e->getMessage()], $e->getCode());
    }
}

router($uri, $requestMethod);

?>
