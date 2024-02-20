<?php
require_once './config/Database.php';
require_once './Controllers/AdminController.php';
require_once './Controllers/FormationsController.php';
require_once './Controllers/PlanningController.php';
require_once './Controllers/ReportController.php';
require_once './Controllers/ServicesController.php';
require_once './Controllers/StockController.php';
require_once './Controllers/UserController.php';

error_reporting(E_ERROR | E_PARSE);

header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

function exitWithError($message = "Internal Server Error", $code = 500) {
    http_response_code($code);
    echo json_encode(['message' => $message]);
    exit();
}

function exitWithContent($content, $code = 200) {
    http_response_code($code);
    echo json_encode($content);
    exit();
}

function router($uri) {
    $headers = getallheaders();
    $apiKey = $headers['apikey'] ?? '';
    
    if ($apiKey !== 'votre_clé_api_sécurisée') { 
        exitWithError('Unauthorized', 401);
    }

    if (!isset($uri[2])) {
        exitWithError('Not Found', 404);
    }

    if (isset($uri[2])) {
        switch ($uri[2]) {
            case 'admins':
                $controller = new AdminController();
                break;
            case 'formations':
                $controller = new FormationsController();
                break;
            case 'planning':
                $controller = new PlanningController();
                break;
            case 'reports':
                $controller = new ReportController();
                break;
            case 'services':
                $controller = new ServicesController();
                break;
            case 'stocks':
                $controller = new StockController();
                break;
            case 'users':
                $controller = new UserController();
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'GET':
                        if (isset($uri[3])) {
                            $controller->getUser($uri[3]);
                        } else {
                            $controller->getAllUsers();
                        }
                        break;
                    case 'POST':
                        $controller->addUser();
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
                        exitWithError('Method Not Allowed', 405);
                        break;
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


