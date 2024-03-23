<?php

// file: api/index.php
header("Content-Type: application/json"); 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once 'Controllers/AdminController.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/LoginController.php';
require_once 'Controllers/TicketController.php';
require_once 'Controllers/VolunteerController.php';
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
         case "login":
            if ($requestMethod === 'POST') {
                $controller = new LoginController();
                $controller->login();
            } else {
                sendJsonResponse(['message' => 'Method Not Allowed'], 405);
            }
            break;
        case 'admins':
            $controller = new AdminController();
            break;
        case 'users':
            $controller = new UserController();
            break;
        case 'tickets': 
            $controller = new TicketController();
            break;
        case 'volunteers':
            // Gestion spécifique pour les bénévoles
            $controller = new AdminController();
            break;
        default:
            sendJsonResponse(['message' => 'Not Found'], 404);
            return;
    }

    try {
        switch ($requestMethod) {
            case 'GET':
                if (isset($uri[3])) {
                    $controller->getAdmin($uri[3]);
                } else {
                    $controller->getAllAdmins();
                }
                break;
            case 'POST':
                $controller->registerAdmin();
                break;
            case 'PUT':
                if ($uri[2] === 'volunteers' && isset($uri[3]) && isset($uri[4])) {
                    switch ($uri[4]) {
                        case 'approve':
                            $controller->approveVolunteer($uri[3]);
                            break;
                        case 'hold':
                            $controller->holdVolunteer($uri[3]);
                            break;
                        case 'reject':
                            $controller->rejectVolunteer($uri[3]);
                            break;
                        default:
                            sendJsonResponse(['message' => 'Action Not Found'], 404);
                    }
                } else if (isset($uri[3])) {
                    $controller->updateAdmin($uri[3]);
                }
                break;
            case 'DELETE':
                if (isset($uri[3])) {
                    $controller->deleteAdmin($uri[3]);
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
