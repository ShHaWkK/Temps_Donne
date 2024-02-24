<?php

// file: api/index.php

// header("Content-Type: application/json; charset=utf8");
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

// function sendJsonResponse($data, $statusCode = 200) {
//     http_response_code($statusCode);
//     echo json_encode($data);
//     exit();
// }

function router($uri) {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $controller = null;
    if (isset($uri[2])) {

        switch ($uri[2]) {
            case 'admins':
                $controller = new AdminController();
                break;
            case 'users':
                $controller = new UserController();
                switch ($requestMethod) {
                    case 'GET':
                        if (isset($uri[3])) {
                            $controller->getUser($uri[3]);
                        } else {
                            exit; 
                            $controller->getAllUsers();
                            
                        }
                        break;
                        case 'volunteers':
                            $controller = new UserController();
                            if ($requestMethod == 'POST') {
                                $controller->registerVolunteer();
                                break;
                            }
                                default:
                                    exitWithError('Method Not Allowed', 405);
                                    break;
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


router($uri);
// router(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
// $controller = new UserController();
// $controller->processRequest($method, $uri);

?>
