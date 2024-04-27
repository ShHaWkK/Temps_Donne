<?php
require_once './Services/LoginService.php';
require_once './Helpers/ResponseHelper.php';
require_once './Repository/UserRepository.php';
require_once './Exceptions/AuthenticationException.php';
require_once './Exceptions/RoleException.php';

class LoginController {
    private $userService;

    public function login() {
        try {
            $json = file_get_contents("php://input");
            $credentials = json_decode($json, true);

            $loginService = new LoginService();
            $loginService->authenticate($credentials['email'], $credentials["password"], $credentials["role"]);
            //$user = $this->userService->authentificate($credentials['email'], $credentials['password']);
            http_response_code(200);
            //echo json_encode(array("message" => "Authentification réussie."));
            ResponseHelper::sendResponse(['message' => 'Authentification réussie.']);
        } catch (RoleException $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
            /*
            echo json_encode(array("message" => "Authentification non réussie."));
            exit_with_message($e->errorMessage(), 403);
            */
        }
    }
}
?>

