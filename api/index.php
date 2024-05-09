<?php
// file: api/index.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

//-------------------- CORS --------------------//
// Autorise les requêtes depuis localhost
//header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS,PATCH');
header('Access-Control-Allow-Headers: Content-Type, Authorization, auth');
header("Access-Control-Allow-Origin: http://localhost:8083");
header('Access-Control-Allow-Credentials: true');

//-------------------- ROUTER --------------------//
require_once 'Controllers/AdminController.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/LoginController.php';
require_once 'Controllers/ServiceController.php';
require_once 'Controllers/FormationController.php';
require_once 'Controllers/StockController.php';
require_once 'Controllers/CircuitController.php';
require_once 'Controllers/EntrepotController.php';
require_once 'Controllers/ProduitController.php';
require_once 'Controllers/AvailabilityController.php';
// require_once 'Controllers/TicketController.php';
require_once 'Controllers/PlanningController.php';
require_once 'Controllers/SkillController.php';
require_once 'Controllers/CamionController.php';
require_once 'Controllers/CommercantController.php';
require_once 'Helpers/ResponseHelper.php';
require_once  __DIR__ . '/vendor/autoload.php';

//require_once 'vendor/autoload.php';


error_reporting(E_ERROR | E_PARSE);

$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requestMethod = $_SERVER['REQUEST_METHOD'];

function sendJsonResponse($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
}


/*
 * Arrêter le code pour envoyer un message à l'utilisateur
 */
function exit_with_message($message = "Internal Server Error", $code = 500) {
    http_response_code($code);
    echo '{"message": "' . $message . '"}';
    exit();
}

/*
 * Arrête le code et envoie les données
 */
function exit_with_content($content = null, $code = 200) {
    http_response_code($code);
    echo json_encode($content);
    exit();
}

// Vérifier si la méthode de la requête est OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

//-------------------- ROUTER --------------------//

/**
 * @throws Exception
 */
function router($uri, $requestMethod) {
    $controller = null;

    if (!isset($uri[2])) {
        exit_with_message("Welcome to the API!");
    }


    //---------------------- ROUTES ----------------------//
    switch ($uri[2]) {
        case "login":
            $controller = new LoginController();
            if ($requestMethod === 'POST') {
                $controller->login();
            } else {
                exit_with_message('Method Not Allowed', 405);
            }
            break;
        case 'admins':
            $adminController = new AdminController();
            $userController = new UserController();
            $adminController->processRequest($requestMethod,$uri,$userController);
            break;
        case 'stocks':
            $stockController = new StockController();
            $stockController->processRequest($requestMethod, $uri);
            break;
        case 'produits':
            $produitController =  new ProduitController();
            $produitController->processRequest($requestMethod, $uri);
            break;
        case 'users':
        case 'beneficiaries':
        case 'volunteers':
            $controller = new UserController();
            $controller->processRequest($requestMethod,$uri);
            break;
        case 'services':
            $controller = new ServiceController();
            $controller->processRequest($requestMethod,$uri);
            break;
        case 'tickets':
            //$controller = new TicketController();
            // Ajoutez ici les cas pour les méthodes HTTP que vous souhaitez gérer pour les tickets
            break;
        case 'planning':
            $controller = new PlanningController();
            $controller->processRequest($requestMethod,$uri);
            break;
        case 'formations':
            $controller = new FormationController();
            $controller->processRequest($requestMethod, $uri);
            break;
        case 'circuits':
            $controller = new CircuitController();
            $controller->processRequest($requestMethod, $uri);
            break;
        case 'entrepots':
            $controller = new EntrepotController();
            $controller->processRequest($requestMethod, $uri);
            break;
        case 'skills':
            $controller=new SkillController();
            $controller->processRequest($requestMethod,$uri);
            break;
        case 'availabilities':
            $controller=new AvailabilityController();
            $controller->processRequest($requestMethod,$uri);
            break;
        case 'trucks':
            $controller=new CamionController();
            $controller->processRequest($requestMethod,$uri);
            break;
        case 'partners':
            $controller=new CommercantController();
            $controller->processRequest($requestMethod,$uri);
            break;
        default:
            exit_with_message('Not Found', 404);
            return;
    }
    // Gestion des erreurs
    try {
        // Traitement spécifique pour d'autres routes si nécessaire
    } catch (Exception $e) {
        exit_with_message($e->getMessage(), 500);
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