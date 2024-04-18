<?php
// file: api/index.php

//-------------------- CORS --------------------//
// Autorise les requêtes depuis localhost
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS,PATCH');
header('Access-Control-Allow-Headers: Content-Type, Authorization, auth');

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

// Vérifier si la méthode de la requête est OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
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
            if ($requestMethod === 'POST') {
                $controller->login();
            } else {
                sendJsonResponse(['message' => 'Method Not Allowed'], 405);
            }
            break;

        case 'admins':
            $adminController = new AdminController();
            $userController = new UserController();
            $adminController->processRequest($requestMethod,$uri,$userController);
            break;

        case 'users':
        case 'beneficiaries':
        case 'volunteers':
        $controller = new UserController();
            $controller->processRequest($requestMethod,$uri);
        break;

        case 'tickets':
            //$controller = new TicketController();
            // Ajoutez ici les cas pour les méthodes HTTP que vous souhaitez gérer pour les tickets
            break;
        case 'planning':
            $controller = new PlanningController();
            // Ajoutez ici les cas pour les méthodes HTTP que vous souhaitez gérer pour la planification
            break;
        default:
            sendJsonResponse(['message' => 'Not Found'], 404);
            return;
    }

    // Gestion des erreurs
    try {
        // Traitement spécifique pour d'autres routes si nécessaire
    } catch (Exception $e) {
        sendJsonResponse(['error' => $e->getMessage()], $e->getCode());
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

router($uri, $requestMethod);

?>
