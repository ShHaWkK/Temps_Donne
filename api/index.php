<?php

// file: api/index.php

//-------------------- CORS --------------------//
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//-------------------- ROUTER --------------------//
require_once 'Controllers/AdminController.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/LoginController.php';
// require_once 'Controllers/TicketController.php';
require_once 'Controllers/PlanningController.php';
require_once 'Helpers/ResponseHelper.php';

error_reporting(E_ERROR | E_PARSE);

$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requestMethod = $_SERVER['REQUEST_METHOD'];

function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit();
}

//-------------------- ROUTER --------------------//

function router($uri, $requestMethod) {
    $controller = null;
    if (!isset($uri[2])) {
        sendJsonResponse(['message' => 'Not Found'], 404);
        return;
    }

    //---------------------- ROUTES ----------------------//
    switch ($uri[2]) {
        case "login":
            $controller = new LoginController();
            break;
        case 'admins':
        case 'volunteers':
            $controller = new AdminController();
            break;
        case 'users':
            $controller = new UserController();
            break;
        case 'tickets':
            $controller = new TicketController();
            break;
        case 'planning':
            $controller = new PlanningController();
            break;
        default:
            sendJsonResponse(['message' => 'Not Found'], 404);
            return;
    }



    try {
        // Gestionn de Login
        if ($uri[2] === 'login') {
            $loginController = new LoginController();
            $loginController->login();
        }
        // Pour les users => créer juste un user, voir ,supprimer et mettre à jour
        if ($uri[2] === 'users') {
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
            }
        }
        // Gestion des requêtes pour 'planning'
        /*
        if ($uri[2] === 'planning') {
           $planningController = new PlanningController();
           switch ($requestMethod) {
               case 'GET':
                   if (isset($uri[3])) {
                       $planningController->getPlanning($uri[3]);
                   } else {
                       $planningController->getAllPlannings();
                   }
                   break;
               case 'POST':
                   $planningController->addPlanning();
                   break;
               case 'PUT':
                   if (isset($uri[3])) {
                       $planningController->updatePlanning($uri[3]);
                   }
                   break;
               case 'DELETE':
                   if (isset($uri[3])) {
                       $planningController->deletePlanning($uri[3]);
                   }
                   break;
               default:
                   sendJsonResponse(['message' => 'Method Not Allowed'], 405);
                   break;
           }
       } else {
           // Gestion des requêtes pour 'tickets'
           if ($uri[2] === 'tickets') {
               $ticketController->processRequest($requestMethod, $uri);
           } else {
               // Gestion des requêtes pour 'users'
               if ($uri[2] === 'users') {
                   $controller->processRequest($requestMethod, $uri);
               } else {
                   // Gestion des requêtes pour 'admins'
                   if ($uri[2] === 'admins') {
                       $controller->processRequest($requestMethod, $uri);
                   }
               }
           }
       } */

        switch ($requestMethod) {

            case 'GET':
                if (isset($uri[3])) {
                    $controller->getAdmin($uri[3]);
                } else {
                    $controller->getAllAdmins();
                }
                break;
            case 'POST':
                if ($uri[2] === 'login') {
                    $controller->processRequest($requestMethod, $uri);
                } else if ($uri[2] === 'volunteers') {
                    $controller->registerVolunteer();
                } else {
                    $controller->registerAdmin();
                }
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
